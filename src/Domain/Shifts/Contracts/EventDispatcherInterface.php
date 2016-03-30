<?php

namespace Domain\Shifts\Contracts;

interface EventDispatcherInterface
{
    /**
     * Dispatches an event to all registered listeners.
     *
     * @param EventInterface  $event     The event to pass to the event handlers/listeners.
     *                          If not supplied, an empty Event instance is created.
     *
     *
     */
    public function dispatch(EventInterface $event);
}
