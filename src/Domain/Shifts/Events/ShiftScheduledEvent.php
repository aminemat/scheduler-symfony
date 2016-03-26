<?php

namespace Domain\Shifts\Events;

use Domain\Shifts\Entities\Shift;

class ShiftScheduledEvent
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
}
