<?php

namespace Application\Listener;

use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;

class CareerServiceMailListener implements ListenerAggregateInterface
{

    public function attach(EventManagerInterface $events, $priority = 1)
    {
    }

    public function detach(EventManagerInterface $events)
    {
    }
}
