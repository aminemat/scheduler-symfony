<?php

namespace Domain\Shifts\Commands;

use DateTime;
use Domain\Shifts\DateRange;

class ScheduleShiftCommand
{
    /**
     * @var int
     */
    private $employeeId;

    /**
     * @var DateRange
     */
    private $dateRange;

    /**
     * ScheduleShiftCommand constructor.
     *
     * @param int       $employeeId
     * @param DateRange $dateRange
     *
     */
    public function __construct(
        $employeeId,
        DateRange $dateRange
    ) {
        $this->employeeId = $employeeId;
        $this->dateRange = $dateRange;
    }

    /**
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
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
