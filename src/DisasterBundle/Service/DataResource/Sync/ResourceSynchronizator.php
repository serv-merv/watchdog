<?php
declare(strict_types=1);


namespace DisasterBundle\Service\DataResource\Sync;

use DisasterBundle\Service\DataResource\ResourceInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class ResourceSynchronizator
 * @package DisasterBundle\Service\DataResource\Sync
 */
final class ResourceSynchronizator
{
    /** @var ResourceInterface */
    private $resource;

    /** @var EntityManager */
    private $entityManager;

    /**
     * ResourceSynchronizator constructor.
     * @param ResourceInterface $resourceUri
     * @param EntityManager $entityManager
     */
    public function __construct(
        ResourceInterface $resourceUri,
        EntityManager $entityManager)
    {
        $this->resource = $resourceUri;
        $this->entityManager = $entityManager;
    }

    public function sync()
    {
        foreach ($this->resource->get() as $key => $resource) {
            $this->entityManager->persist($resource);
            if (($key % 250) === 0) {
                $this->entityManager->flush();
            }
        }
        $this->entityManager->flush();
    }
}