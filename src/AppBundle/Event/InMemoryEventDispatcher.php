<?php

namespace AppBundle\Event;

use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Shifts\Contracts\EventInterface;

class InMemoryEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var EventInterface[]
     */
    private $events;

    /**
     * InMemoryEventDispatcher constructor.
     */
    public function __construct()
    {
        $this->events = [];
    }
    
    /**
     * Dispatches an event to all registered listeners.
     *
     * @param EventInterface $event
     *
     * @return EventInterface
     */
    public function dispatch(EventInterface $event = null)
    {
        $this->events[] = $event;
    }
}
