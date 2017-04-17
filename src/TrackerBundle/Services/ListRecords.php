<?php


namespace TrackerBundle\Services;

use Doctrine\ORM\EntityManager;
use TrackerBundle\Entity\Record;

class ListRecords
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(): array
    {
        $records = $this->entityManager
            ->getRepository(Record::class)
            ->findAll();

        return $records;
    }
}