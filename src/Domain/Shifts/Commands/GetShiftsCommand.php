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
    private $userId;

    /**
     * @var DateRange
     */
    private $dateRange;

    /**
     * GetShiftsCommand constructor.
     *
     * @param int       $locationId
     * @param int       $userId
     * @param DateRange $dateRange
     */
    public function __construct(DateRange $dateRange, $locationId, $userId = null)
    {
        $this->locationId = $locationId;
        $this->userId = $userId;
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
