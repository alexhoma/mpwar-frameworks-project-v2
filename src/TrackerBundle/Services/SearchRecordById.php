<?php

namespace TrackerBundle\Services;

use Doctrine\ORM\EntityManager;
use TrackerBundle\Entity\Record;

class SearchRecordById
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($recordId)
    {
        $record = $this->entityManager
            ->getRepository(Record::class)
            ->find($recordId);

        $this->ensureRecordExists($record);

        return $record;
    }

    /**
     * @param $record
     */
    private function ensureRecordExists($record)
    {
        if (!$record) {
            throw $this->createNotFoundException('Record not found!');
        }
    }
}