<?php

namespace TrackerBundle\Services;

use TrackerBundle\Entity\RecordRepository;


class SearchRecordById
{
    private $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    )
    {
        $this->recordRepository = $recordRepository;
    }

    public function __invoke(int $recordId)
    {
        $record = $this->recordRepository->findById($recordId);
        $this->ensureRecordExists($record, $recordId);

        return $record;
    }

    /**
     * Guard clause to ensure if a record exists
     * otherwise throws a NotFoundException
     *
     * @param $record
     * @param $recordId
     */
    private function ensureRecordExists($record, $recordId)
    {
        if (!$record) {
            throw $this->createNotFoundException(
                'Record with id:' . $recordId . ' not found!'
            );
        }
    }
}