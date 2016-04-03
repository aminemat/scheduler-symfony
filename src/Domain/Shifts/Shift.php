<?php

namespace Domain\Shifts;

use DateTime;
use Domain\Employees\Employee;
use Domain\Shifts;
use Ramsey\Uuid\Uuid;

class Shift
{
    /**
     * @var Uuid
     */
    private $id;

    /**
     * @var DateTime
     */
    private $startTime;

    /**
     * @var DateTime
     */
    private $endTime;

    /**
     * @var Employee
     */
    private $employee;

    /**
     * @var ShiftStatus
     */
    private $status;

    /**
     * Shift constructor.
     *
     * @param Employee $employee
     * @param DateTime $startTime
     * @param DateTime $endTime
     * @param string   $status
     */
    public function __construct(
        Employee $employee,
        DateTime $startTime,
        DateTime $endTime,
        $status = ShiftStatus::SCHEDULED
    ) {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->employee = $employee;
        $this->status = $status;
    }

    public function markAsPending()
    {
        $this->status == ShiftStatus::PENDING();
    }

    /**
     * @return Uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @return ShiftStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
}
