<?php
declare(strict_types=1);


namespace DisasterBundle\Service;

use DisasterBundle\Dto\CoordinatesDto;

/**
 * Class DistanceBasedOnCoordinatesCalculator
 * @package DisasterBundle\Service
 */
class HaversineFormulaCalculator implements DistanceCalculatorInterface
{
    private const EARTH_RADIUS = 6371;

    /**
     * @param CoordinatesDto $coordinatesDtoTo
     * @param CoordinatesDto $coordinatesDtoFrom
     * @return int
     */
    public function calculate(CoordinatesDto $coordinatesDtoTo, CoordinatesDto $coordinatesDtoFrom)
    {
        $dLatRad = $this->toRadian($coordinatesDtoFrom->latitude - $coordinatesDtoTo->latitude);
        $dLongRad = $this->toRadian($coordinatesDtoFrom->longitude - $coordinatesDtoTo->longitude);

        $latToRad = $this->toRadian($coordinatesDtoTo->latitude);
        $latFromRad = $this->toRadian($coordinatesDtoFrom->latitude);

        $a = sin($dLatRad / 2) ** 2 + (sin($dLongRad / 2) ** 2) * cos($latToRad) * cos($latFromRad);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return static::EARTH_RADIUS * $c;
    }

    /**
     * @param float $degrees
     * @return float
     */
    private function toRadian(float $degrees)
    {
        return $degrees * M_PI / 180;
    }
}