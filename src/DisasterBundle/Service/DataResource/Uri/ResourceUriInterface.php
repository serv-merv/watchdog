<?php
declare(strict_types=1);


namespace DisasterBundle\Service\DataResource\Uri;


/**
 * Interface ResourceUriInterface
 * @package DisasterBundle\Service\DataResource\Uri
 */
interface ResourceUriInterface
{
    /**
     * @return string
     */
    public function getUri(): string;
}