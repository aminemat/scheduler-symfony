<?php

namespace Domain\Shifts\Commands;

use DateTime;
use Domain\Shifts\Entities\DateRange;

class ScheduleShiftCommand
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var DateRange
     */
    private $dateRange;

    /**
     * ScheduleShiftCommand constructor.
     *
     * @param int       $userId
     * @param DateRange $dateRange
     *
     */
    public function __construct(
        $userId,
        DateRange $dateRange
    ) {
        $this->userId = $userId;
        $this->dateRange = $dateRange;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Returns the start date
     *
     * @return DateTime
     */
    public function from()
    {
        return $this->dateRange->getStartDate();
    }

    /**
     * Returns the end date
     *
     * @return DateTime
     */
    public function to()
    {
        return $this->dateRange->getEndDate();
    }
}
