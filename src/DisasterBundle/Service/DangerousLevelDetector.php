<?php
declare(strict_types=1);


namespace DisasterBundle\Service;

use DisasterBundle\Dto\CoordinatesDto;
use DisasterBundle\Dto\DisasterDto;
use DisasterBundle\Entity\Disaster;
use DisasterBundle\Enum\DisasterSafetyLevelEnum;
use Doctrine\ORM\EntityManager;

/**
 * Class DangerousLevelDetector
 * @package DisasterBundle\Service
 */
class DangerousLevelDetector implements DangerousLevelDetectorInterface
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * DangerousLevelDetector constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param float $lat
     * @param float $long
     * @param int $limit
     * @return array
     */
    public function detect(float $lat, float $long, int $limit = 5)
    {
        $disasterRepository = $this->entityManager->getRepository('DisasterBundle:Disaster');
        $disastersData = $disasterRepository->findWithLimitAndCurrentPosition($lat, $long, $limit);
        $disasters = [];
        foreach ($disastersData as $disaster) {
            $disasters[$disaster['disaster_distance']] = $disasterRepository->find($disaster['disaster_id']);
        }
        $recognizedDisasters = [];

        /** @var Disaster $disaster */
        foreach ($disasters as $distance => $disaster) {
            $distance = (float)$distance;
            $disasterLevel = $this->getLevelByDistance($disaster, $distance);
            $disasterDto = $disaster->toDto();
            $disasterDto->dangerLevel = $disasterLevel;
            $disasterDto->distanceTo = round($distance, 4);
            $recognizedDisasters[] = $disasterDto;
        }


        usort($recognizedDisasters, function (DisasterDto $a, DisasterDto $b) {
            return $a->distanceTo > $b->distanceTo;
        });
        return $recognizedDisasters;
    }

    /**
     * @param Disaster $disaster
     * @param float $distance
     * @return string
     */
    private function getLevelByDistance(Disaster $disaster, float $distance)
    {
        if ($distance > $disaster->getSafeDistance()
            || ($distance < $disaster->getSafeDistance() && $distance > $disaster->getWarningDistance())
        ) {
            return DisasterSafetyLevelEnum::SAFE;
        }
        if ($distance < $disaster->getWarningDistance() && $distance > $disaster->getDangerDistance()) {
            return DisasterSafetyLevelEnum::WARNING;
        }
        if ($distance <= $disaster->getDangerDistance()) {
            return DisasterSafetyLevelEnum::DANGER;
        }
        return DisasterSafetyLevelEnum::SAFE;
    }
}