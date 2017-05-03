<?php
declare(strict_types=1);


namespace DisasterBundle\Service\DataResource\Earthquake;

use DisasterBundle\Entity\Earthquake;
use DisasterBundle\Enum\DisasterSafetyLevelEnum;
use DisasterBundle\Service\DataResource\DangerLevelDetector;
use DisasterBundle\Service\DataResource\ResourceInterface;
use DisasterBundle\Service\DataResource\Uri\USGSResourceUri;
use GuzzleHttp\Client;

/**
 * Class USGSDataResource
 * @package DisasterBundle\Service\DataResource
 */
class USGSDataResource implements ResourceInterface, DangerLevelDetector
{
    /** @var USGSResourceUri */
    private $uriResource;

    /**
     * USGSDataResource constructor.
     */
    public function __construct()
    {
        $this->uriResource = new USGSResourceUri();
    }

    /**
     * @return \Generator
     */
    public function get()
    {
        $client = new Client();
        $response = $client->get($this->uriResource->getUri());
        $contents = $response->getBody()->getContents();
        $decodedContent = json_decode($contents, true);
        $earthquakes = $decodedContent['features'];

        /** @var array $earthquake */
        foreach ($earthquakes as $earthquake) {
            $properties = $earthquake['properties'];
            $magnitude = $properties['mag'];
            $coordinates = $earthquake['geometry']['coordinates'];
            $earthquake = new Earthquake($coordinates[1], $coordinates[0]);
            if ($magnitude) {
                $radius = $this->calculateRadius($magnitude);
                $level = $this->detectDangerLevel($magnitude);
                $earthquake->setStatus($level);
                $earthquake->setDangerDistance($radius);
                $earthquake->setWarningDistance($radius + 100);
                $earthquake->setSafeDistance($radius + 250);
            }
            $earthquake->setDescription($properties['title']);
            $earthquake->setDetail($properties['detail']);

            yield $earthquake;
        }
    }

    /**
     * @param float $magnitude
     * @return string
     */
    public function detectDangerLevel($magnitude)
    {
        if (($magnitude >= 1.0 && $magnitude <= 3.9) || $magnitude < 1.0) {
            return DisasterSafetyLevelEnum::SAFE;
        }
        if ($magnitude > 3.9 && $magnitude <= 5.9) {
            return DisasterSafetyLevelEnum::WARNING;
        }
        if (($magnitude > 5.9 && $magnitude <= 9.0)
            || $magnitude > 9.0
        ) {
            return DisasterSafetyLevelEnum::DANGER;
        }
        return DisasterSafetyLevelEnum::DANGER;
    }

    /**
     * @param float $magnitude
     * @return float
     */
    private function calculateRadius(float $magnitude)
    {
        return exp($magnitude / (1.01 - 0.13));
    }
}