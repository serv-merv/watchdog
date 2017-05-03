<?php
declare(strict_types=1);


namespace DisasterBundle\Service\DataResource\Uri;


/**
 * Class USGSResourceUri
 * @package DisasterBundle\Service\DataResource\Uri
 */
class USGSResourceUri implements ResourceUriInterface
{
    private const DEFAULT_URI_RESOURCE = 'https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson';

    private const DEFAULT_FORMAT = 'Y-m-d';

    /** @var string */
    private $link;

    /** @var \DateTime */
    private $startTime;

    /** @var \DateTime */
    private $endTime;

    /**
     * USGSResourceUri constructor.
     */
    public function __construct()
    {
        $this->link = static::DEFAULT_URI_RESOURCE;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->buildUri();
    }

    /**
     * @return string
     */
    private function buildUri(): string
    {
        $uri = $this->link;
        if ($this->startTime) {
            $uri .= sprintf('&starttime=%s', $this->startTime->format(self::DEFAULT_FORMAT));
        }
        if ($this->endTime) {
            $uri .= sprintf('&endtime=%s', $this->endTime->format(self::DEFAULT_FORMAT));
        }
        return $uri;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime(): ?\DateTime
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime(): ?\DateTime
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime(\DateTime $endTime)
    {
        $this->endTime = $endTime;
    }
}