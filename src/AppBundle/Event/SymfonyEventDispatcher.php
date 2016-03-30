<?php

namespace AppBundle\Event;

use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Shifts\Contracts\EventInterface;

class SymfonyEventDispatcher implements EventDispatcherInterface
{

    /**
     * Dispatches an event to all registered listeners.
     *
     * @param EventInterface $event
     *
     * @return EventInterface
     */
    public function dispatch(EventInterface $event = null)
    {
        // TODO: Implement dispatch() method.
    }
}
