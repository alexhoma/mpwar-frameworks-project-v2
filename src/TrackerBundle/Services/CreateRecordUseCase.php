<?php


namespace TrackerBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TrackerBundle\Entity\Record;
use TrackerBundle\Event\RecordTrackedEvent;

class CreateRecordUseCase
{
    private $entityManager;
    private $eventDispatcher;

    public function __construct(
        EntityManager $entityManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(Record $record)
    {
        $this->entityManager->persist($record);
        $this->entityManager->flush($record);

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