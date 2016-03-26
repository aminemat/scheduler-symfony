<?php

namespace Domain\Shifts\Commands;

use Domain\Shifts\Entities\DateRange;

class GetShiftsCommand
{
    /**
     * @var integer
     */
    private $locationId;

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
     * @param int       $locationId
     * @param int       $employeeId
     * @param DateRange $dateRange
     */
    public function __construct(DateRange $dateRange, $locationId, $employeeId = null)
    {
        $this->locationId = $locationId;
        $this->employeeId = $employeeId;
        $this->dateRange = $dateRange;
    }

    /**
     * @return int
     */
    public function getLocationId()
    {
        return $this->locationId;
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
