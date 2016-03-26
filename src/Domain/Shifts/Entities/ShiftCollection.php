<?php

namespace Domain\Shifts\Entities;

use Domain\Shifts\Entities;

class ShiftCollection
{
    /**
     * @var Shift[]
     */
    private $shifts;

    /**
     * ShiftCollection constructor.
     *
     * @param Shift[] $shifts
     */
    public function __construct(array $shifts)
    {
        $this->shifts = $shifts;
    }
}
