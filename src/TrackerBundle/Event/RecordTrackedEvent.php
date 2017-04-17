<?php

namespace TrackerBundle\Event;

use TrackerBundle\Entity\Record;
use Symfony\Component\EventDispatcher\Event;


class RecordTrackedEvent extends Event
{
    private $record;

    public function __construct(Record $record)
    {
        $this->record = $record;
    }

    public function getRecord()
    {
        return $this->record;
    }
}