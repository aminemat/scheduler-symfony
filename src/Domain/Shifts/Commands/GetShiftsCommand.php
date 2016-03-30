<?php

namespace Domain\Shifts\Commands;

use Domain\Shifts\Entities\DateRange;

class GetShiftsCommand
{
    /**
     * @var
     */
    private $userId;

    /**
     * @var DateRange
     */
    private $dateRange;

    /**
     * GetShiftsCommand constructor.
     *
     * @param int       $userId
     * @param DateRange $dateRange
     */
    public function __construct(DateRange $dateRange, $userId = null)
    {
        $this->userId = $userId;
        $this->dateRange = $dateRange;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return DateRange
     */
    public function getDateRange()
    {
        return $this->dateRange;
    }
}
