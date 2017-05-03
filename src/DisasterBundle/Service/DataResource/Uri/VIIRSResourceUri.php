<?php
declare(strict_types=1);


namespace DisasterBundle\Service\DataResource\Uri;

/**
 * Class VIIRSDataResource
 * @package DisasterBundle\Service\DataResource\Uri
 */
class VIIRSResourceUri implements ResourceUriInterface
{
    private const DEFAULT_FTP_URI = 'nrt3.modaps.eosdis.nasa.gov';

    /**
     * @return string
     */
    public function getUri(): string
    {
        return static::DEFAULT_FTP_URI;
    }
}