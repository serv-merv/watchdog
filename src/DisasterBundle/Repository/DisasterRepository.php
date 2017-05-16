<?php
declare(strict_types=1);


namespace DisasterBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Class DisasterRepository
 * @package DisasterBundle\Repository
 */
class DisasterRepository extends EntityRepository
{
    /**
     * @param float $latitude
     * @param $
     * @param float $longitude
     * @param int $limit
     * @return array
     */
    public function findWithLimitAndCurrentPosition(float $latitude, float $longitude, int $limit)
    {
        $sql = 'SELECT
                  id AS disaster_id,
                  geodistance(?, ?, latitude, longitude) as disaster_distance
                FROM watchdog_disasters
                ORDER BY disaster_distance LIMIT ?';
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql, [
            $latitude,
            $longitude,
            $limit
        ]);

        return $stmt->fetchAll();
    }
}