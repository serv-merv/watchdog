<?php
declare(strict_types=1);


namespace DisasterBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Earthquake
 * @package DisasterBundle\Entity
 * @ORM\Entity(repositoryClass="DisasterBundle\Repository\EarthquakeRepository")
 */
class Earthquake extends Disaster
{
    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private $magnitude;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tsunami;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $detail;

    /**
     * @return float
     */
    public function getMagnitude(): float
    {
        return $this->magnitude;
    }

    /**
     * @param float $magnitude
     */
    public function setMagnitude(float $magnitude)
    {
        $this->magnitude = $magnitude;
    }

    /**
     * @return int
     */
    public function getTsunami(): int
    {
        return $this->tsunami;
    }

    /**
     * @param int $tsunami
     */
    public function setTsunami(int $tsunami)
    {
        $this->tsunami = $tsunami;
    }

    /**
     * @return string
     */
    public function getDetail(): string
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     */
    public function setDetail(string $detail)
    {
        $this->detail = $detail;
    }
}