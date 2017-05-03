<?php
declare(strict_types=1);


namespace DisasterBundle\Service;


use DisasterBundle\Dto\CoordinatesDto;

/**
 * Interface DistanceCalculatorInterface
 * @package DisasterBundle\Service
 */
interface DistanceCalculatorInterface
{
    /**
     * @param CoordinatesDto $coordinatesDtoTo
     * @param CoordinatesDto $coordinatesDtoFrom
     * @return mixed
     */
    public function calculate(CoordinatesDto $coordinatesDtoTo, CoordinatesDto $coordinatesDtoFrom);
}