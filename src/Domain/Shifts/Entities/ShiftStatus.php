<?php

namespace Domain\Shifts\Entities;

use MyCLabs\Enum\Enum;

class ShiftStatus extends Enum
{
    const SCHEDULED = 'scheduled';
    const PENDING = 'pending';
    const CONFLICTED = 'conflicted';
    const ACKNOWLEDGED = 'acknowledged';
}
