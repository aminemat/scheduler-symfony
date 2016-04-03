<?php

namespace AppBundle\Transformers;

use Domain\Shifts\Shift;
use League\Fractal\TransformerAbstract;

class ShiftTransformer extends TransformerAbstract
{
    public function transform(Shift $shift)
    {
        return [
            'id' => $shift->getId(),
            'employee' => $shift->getEmployee()->getName(),
            'start_time' => $shift->getStartTime(),
            'end_time' => $shift->getEndTime(),
            'status' => (string) $shift->getStatus()
        ];
    }
}
