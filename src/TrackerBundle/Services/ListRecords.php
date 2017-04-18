<?php

namespace TrackerBundle\Services;

use TrackerBundle\Entity\RecordRepository;


class ListRecords
{
    private $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    )
    {
        $this->recordRepository = $recordRepository;
    }

    public function __invoke(): array
    {
        $records = $this->recordRepository->list();

        return $records;
    }
}