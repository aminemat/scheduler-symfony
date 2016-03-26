<?php

namespace Domain\Shifts\Contracts;

interface EventDispatcherInterface
{
    /**
     * Dispatches an event to all registered listeners.
     *
     * @param string $eventName The name of the event to dispatch. The name of
     *                          the event is the name of the method that is
     *                          invoked on listeners.
     * @param EventInterface  $event     The event to pass to the event handlers/listeners.
     *                          If not supplied, an empty Event instance is created.
     *
     * @return EventInterface
     *
     * @api
     */
    public function dispatch($eventName, EventInterface $event = null);
}