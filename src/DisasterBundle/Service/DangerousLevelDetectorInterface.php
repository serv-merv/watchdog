<?php
/**
 * Created by PhpStorm.
 * User: serge
 * Date: 5/3/17
 * Time: 9:10 AM
 */

namespace DisasterBundle\Service;


/**
 * Class DangerousLevelDetector
 * @package DisasterBundle\Service
 */
interface DangerousLevelDetectorInterface
{
    /**
     * @param float $lat
     * @param float $long
     * @param int $limit
     * @return mixed
     */
    public function detect(float $lat, float $long, int $limit = 5);
}