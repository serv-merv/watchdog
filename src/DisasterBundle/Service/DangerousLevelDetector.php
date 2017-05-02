<?php
declare(strict_types=1);


namespace DisasterBundle\Service;

use DisasterBundle\Dto\CoordinatesDto;
use DisasterBundle\Entity\Disaster;
use DisasterBundle\Enum\DisasterSafetyLevelEnum;
use Doctrine\ORM\EntityManager;

/**
 * Class DangerousLevelDetector
 * @package DisasterBundle\Service
 */
class DangerousLevelDetector
{
    private const RECOGNIZE_DISTANCE = 150;

    /** @var HaversineFormulaCalculator */
    private $calculator;

    /** @var EntityManager */
    private $entityManager;

    /**
     * DangerousLevelDetector constructor.
     * @param HaversineFormulaCalculator $calculator
     * @param EntityManager $entityManager
     */
    public function __construct(
        HaversineFormulaCalculator $calculator,
        EntityManager $entityManager)
    {
        $this->calculator = $calculator;
        $this->entityManager = $entityManager;
    }

    public function detect(float $lat, float $long)
    {
        $disasterRepository = $this->entityManager->getRepository('DisasterBundle:Disaster');
        $disasters = $disasterRepository->findAll();
        $recognizedDisasters = [];

        /** @var Disaster $disaster */
        foreach ($disasters as $disaster) {
            $toDto = new CoordinatesDto();
            $toDto->latitude = $disaster->getLatitude();
            $toDto->longitude = $disaster->getLongitude();
            $fromDto = new CoordinatesDto();
            $fromDto->latitude = $lat;
            $fromDto->longitude = $long;
            $distance = $this->calculator->calculate($toDto, $fromDto);
            if ($distance < static::RECOGNIZE_DISTANCE) {
                $disasterLevel = $this->getLevelByDistance($disaster, $distance);
                $disasterDto = $disaster->toDto();
                $disasterDto->dangerLevel = $disasterLevel;
                $recognizedDisasters[] = $disasterDto;
            }
        }
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