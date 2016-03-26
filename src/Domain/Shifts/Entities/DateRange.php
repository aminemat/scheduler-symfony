<?php

namespace Domain\Shifts\Entities;

use DateTime;
use InvalidArgumentException;

class DateRange
{
    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var DateTime
     */
    private $endDate;

    /**
     * DateRange constructor.
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     */
    public function __construct(DateTime $startDate, DateTime $endDate)
    {
        if ($startDate > $endDate) {
            throw new InvalidArgumentException('Start date precedes end date');
        }

        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
