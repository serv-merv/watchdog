<?php
declare(strict_types=1);


namespace DisasterBundle\DataFixtures\Orm;


use DisasterBundle\Entity\Disaster;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DisastersFixture
 * @package DisasterBundle\DataFixtures\Orm
 */
class DisastersFixture extends AbstractFixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $disasters = [
            [
                'lat' => 50.43510019,
                'long' => 30.44928813,
                'description' => 'A big fire in Kiev',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ],
            [
                'lat' => 50.34404186,
                'long' => 30.55022502,
                'description' => 'Terrible cars accident',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ],
            [
                'lat' => 50.39528369,
                'long' => 30.3160789,
                'description' => 'Factor was exploded',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ],
            [
                'lat' => 50.52598371,
                'long' => 30.358650923,
                'description' => 'All village went down under the river',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ], [
                'lat' => 50.55260391,
                'long' => 30.19934917,
                'description' => 'Crazy man killed 100 people',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ],
            [
                'lat' => 50.42985158,
                'long' => 30.03180766,
                'description' => 'Some bull shit happened',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ],
            [
                'lat' => 50.3563099,
                'long' => 30.98212504,
                'description' => 'Schoolboys from Boryspil stole black dildo',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ],
            [
                'lat' => 50.45434012,
                'long' => 30.35315776,
                'description' => 'Another bridge goes down',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ], [
                'lat' => 50.48580678,
                'long' => 30.54129863,
                'description' => 'A terrible monster under the water of Dnipro',
                'safe' => random_int(110, 125),
                'warning' => random_int(60, 100),
                'danger' => random_int(1, 50),
            ]
        ];

        /** @var array $disaster */
        foreach ($disasters as $disaster) {
            $instance = new Disaster($disaster['lat'], $disaster['long'], new \DateTime());
            $instance->setDescription($disaster['description']);
            $instance->setSafeDistance($disaster['safe']);
            $instance->setWarningDistance($disaster['warning']);
            $instance->setDangerDistance($disaster['danger']);
            $manager->persist($instance);
        }
        $manager->flush();
    }
}