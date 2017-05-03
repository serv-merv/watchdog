<?php
declare(strict_types=1);


namespace DisasterBundle\Service\DataResource;

/**
 * Interface ResourceInterface
 * @package DisasterBundle\Service\DataResource
 */
interface ResourceInterface
{
    /**
     * @return \Generator
     */
    public function get();
}