<?php

namespace Domain\Shifts\Events;

use Domain\Shifts\Contracts\EventInterface;
use Domain\Shifts\Entities\Shift;

class ShiftScheduledEvent implements EventInterface
{
    /**
     * @var Shift
     */
    private $shift;

    /**
     * ShiftScheduledEvent constructor.
     *
     * @param Shift $shift
     */
    public function __construct(Shift $shift)
    {
        $this->shift = $shift;
    }

    /**
     * Returns the event name
     *
     * @return string
     */
    public function getName()
    {
        return 'shift-scheduled';
    }
}
