<?php
declare(strict_types=1);


namespace DisasterBundle\Dto;


/**
 * Class DisasterDto
 * @package DisasterBundle\Dto
 */
final class DisasterDto
{
    /** @var float */
    public $latitude;

    /** @var float */
    public $longitude;

    /** @var string */
    public $description;

    /** @var array */
    public $images;

    /** @var array */
    public $videos;

    /** @var string */
    public $dangerLevel;

    /** @var float */
    public $safeZone;

    /** @var float */
    public $warningZone;

    /** @var float */
    public $dangerZone;
}