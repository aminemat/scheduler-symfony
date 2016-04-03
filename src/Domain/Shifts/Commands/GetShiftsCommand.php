<?php

namespace Domain\Shifts\Commands;

use Domain\Shifts\Entities\DateRange;

class GetShiftsCommand
{
    /**
     * @var
     */
    private $employeeId;

    /**
     * @var DateRange
     */
    private $dateRange;

    /**
     * GetShiftsCommand constructor.
     *
     * @param int       $employeeId
     * @param DateRange $dateRange
     */
    public function __construct(DateRange $dateRange, $employeeId = null)
    {
        $this->employeeId = $employeeId;
        $this->dateRange = $dateRange;
    }

    /**
     * @return mixed
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * @return DateRange
     */
    public function getDateRange()
    {
        return $this->dateRange;
    }
}
