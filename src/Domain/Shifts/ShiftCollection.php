<?php

namespace Domain\Shifts;

use Domain\Shifts;

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
