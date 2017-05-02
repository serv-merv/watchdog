<?php
declare(strict_types=1);


namespace DisasterBundle\Entity;
use DisasterBundle\Dto\DisasterDto;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Disaster
 * @package DisasterBundle\Entity
 * @ORM\Entity(repositoryClass="DisasterBundle\Repository\DisasterRepository")
 * @ORM\Table("watchdog_disasters")
 */
class Disaster
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var array
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $images;

    /**
     * @var array
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $videos;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $safeDistance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $warningDistance;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $dangerDistance;

    /**
     * Disaster constructor.
     * @param float $lat
     * @param float $long
     */
    public function __construct(float $lat, float $long)
    {
        $this->id = sha1(uniqid('', true));
        $this->latitude = $lat;
        $this->longitude = $long;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    }

    /**
     * @return float
     */
    public function getSafeDistance(): float
    {
        return $this->safeDistance;
    }

    /**
     * @param float $safeDistance
     */
    public function setSafeDistance(float $safeDistance)
    {
        $this->safeDistance = $safeDistance;
    }

    /**
     * @return float
     */
    public function getWarningDistance(): float
    {
        return $this->warningDistance;
    }

    /**
     * @param float $warningDistance
     */
    public function setWarningDistance(float $warningDistance)
    {
        $this->warningDistance = $warningDistance;
    }

    /**
     * @return float
     */
    public function getDangerDistance(): float
    {
        return $this->dangerDistance;
    }

    /**
     * @param float $dangerDistance
     */
    public function setDangerDistance(float $dangerDistance)
    {
        $this->dangerDistance = $dangerDistance;
    }

    /**
     * @return DisasterDto
     */
    public function toDto(): DisasterDto
    {
        $dto = new DisasterDto();
        $dto->longitude = $this->longitude;
        $dto->latitude = $this->latitude;
        $dto->description = $this->description;
        $dto->images = $this->images;
        $dto->videos = $this->videos;
        $dto->safeZone = $this->safeDistance;
        $dto->warningZone = $this->warningDistance;
        $dto->dangerZone = $this->dangerDistance;
        return $dto;
    }
}