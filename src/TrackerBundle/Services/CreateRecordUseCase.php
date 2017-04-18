<?php


namespace TrackerBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TrackerBundle\Entity\Record;
use TrackerBundle\Entity\RecordRepository;
use TrackerBundle\Event\RecordTrackedEvent;

class CreateRecordUseCase
{
    private $eventDispatcher;
    private $recordRepository;

    public function __construct(
        RecordRepository $recordRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->recordRepository = $recordRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(Record $record)
    {
        $this->recordRepository->save($record);
        $this->throwRecordTrackerEvent($record);
    }

    /**
     * Throws an event when a record is created
     *
     * @param $record
     */
    private function throwRecordTrackerEvent(Record $record)
    {
        $recordTrackedEvent = new RecordTrackedEvent($record);
        $this->eventDispatcher->dispatch('record.tracked', $recordTrackedEvent);
    }
}