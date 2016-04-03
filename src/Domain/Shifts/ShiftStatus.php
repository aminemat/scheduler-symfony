<?php

namespace Domain\Shifts;

use MyCLabs\Enum\Enum;

class ShiftStatus extends Enum
{
    const SCHEDULED = 'scheduled';
    const PENDING = 'pending';
    const CONFLICTED = 'conflicted';
    const ACKNOWLEDGED = 'acknowledged';
}
