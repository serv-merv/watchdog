<?php
declare(strict_types=1);


namespace DisasterBundle\Service\DataResource\Fire;


use DisasterBundle\Entity\Fire;
use DisasterBundle\Enum\DisasterSafetyLevelEnum;
use DisasterBundle\Service\DataResource\DangerLevelDetector;
use DisasterBundle\Service\DataResource\ResourceInterface;
use DisasterBundle\Service\DataResource\Uri\VIIRSResourceUri;
use Ijanki\Bundle\FtpBundle\Ftp;

/**
 * Class VIIRSDataResource
 * @package DisasterBundle\Service\DataResource\Fire
 */
class VIIRSDataResource implements ResourceInterface, DangerLevelDetector
{
    private const PIXEL_SIZE = 375;
    private const METERS_IN_KILOMETERS = 1000;

    /** @var VIIRSResourceUri */
    private $resource;

    /** @var Ftp */
    private $ftp;

    /**
     * VIIRSDataResource constructor.
     * @param Ftp $ftp
     * @param string $login
     * @param string $password
     */
    public function __construct(Ftp $ftp, string $login, string $password)
    {
        $this->ftp = $ftp;
        $this->resource = new VIIRSResourceUri();
        $this->ftp->connect($this->resource->getUri());
        $this->ftp->login($login, $password);
    }

    /**
     * @return \Generator
     */
    public function get()
    {
        $this->ftp->chdir('FIRMS');
        $this->ftp->chdir('viirs');
        $this->ftp->chdir('Global');
        $this->ftp->pasv(true);
        $rawList = $this->ftp->rawlist('');
        $rawList = $this->sortByDate($rawList);
        $tmp_handle = fopen('php://temp', 'rb+');
        $this->ftp->fget($tmp_handle, $rawList[0]['name'], FTP_TEXT);
        rewind($tmp_handle);
        $this->ftp->close();
        $content = preg_split("/((\r?\n)|(\r\n?))/", stream_get_contents($tmp_handle));
        foreach ($content as $key => $line) {
            if ($key === 0) {
                continue;
            }
            $data = explode(',', $line);
            $fire = new Fire((float)$data[0], (float)$data[1], new \DateTime($data[5] . ' ' . $data[6]));
            $fire->setBrightTI4((float)$data[2]);
            $fire->setBrightTI5((float)$data[10]);
            $fire->setStatus($this->detectDangerLevel($data));
            $dangerRadius = $this->getRadius((float)$data[4]);
            $fire->setDangerDistance($dangerRadius / static::METERS_IN_KILOMETERS);
            $fire->setWarningDistance(($dangerRadius + 50) / static::METERS_IN_KILOMETERS);
            $fire->setSafeDistance(($dangerRadius + 100) / static::METERS_IN_KILOMETERS);
            yield $fire;
        }
    }

    /**
     * @param array $list
     * @return array
     */
    private function sortByDate(array $list)
    {
        $results = array();
        foreach ($list as $line) {
            list($perms, $links, $user, $group, $size, $d1, $d2, $d3, $name) =
                preg_split('/\s+/', $line, 9);
            $stamp = strtotime(implode(' ', array($d1, $d2, $d3)));
            $results[] = array('name' => $name, 'timestamp' => $stamp);
        }

        usort($results, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });
        return $results;
    }

    /**
     * @param float $actualPixelSize
     * @return float
     */
    private function getRadius(float $actualPixelSize)
    {
        $diameter = $actualPixelSize * static::PIXEL_SIZE;
        return $diameter / 2;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function detectDangerLevel($data)
    {
        [$scan, $track] = [(float)$data[3], (float)$data[4]];

        $scannedRadius = $this->getRadius($scan);
        $trackedRadius = $this->getRadius($track);
        $diff = abs($scannedRadius - $trackedRadius);
        $level = DisasterSafetyLevelEnum::SAFE;
        if ($diff > 15 && $diff <= 25) {
            $level = DisasterSafetyLevelEnum::WARNING;
        } else if ($diff > 26) {
            $level = DisasterSafetyLevelEnum::DANGER;
        }
        return $level;
    }
}