<?php

namespace Domain\Shifts\Contracts;

interface EventInterface
{
    /**
     * Returns the event name
     * @return string
     */
    public function getName();
}