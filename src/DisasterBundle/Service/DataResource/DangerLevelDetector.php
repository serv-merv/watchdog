<?php
declare(strict_types=1);


namespace DisasterBundle\Service\DataResource;

/**
 * Interface DangerLevelDetector
 * @package DisasterBundle\Service\DataResource
 */
interface DangerLevelDetector
{
    /**
     * @param $basedOn
     * @return mixed
     */
    public function detectDangerLevel($basedOn);
}