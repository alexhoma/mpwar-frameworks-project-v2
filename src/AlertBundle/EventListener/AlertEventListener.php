<?php

namespace AlertBundle\EventListener;


use AlertBundle\Services\Alert;

class AlertEventListener
{
    private $alert;

    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    public function callAlert($event)
    {
        $this
            ->alert
            ->shouldAlert($event->getRecord());
    }
}