<?php

namespace Domain\Users\Contracts;

use DateTime;
use Domain\Users\Contracts\Exception\EmployeeNotFoundException;
use Domain\Users\Entities\User;

interface EmployeeRepositoryInterface
{
    /**
     * Finds an employee by ID
     *
     * @param $employeeId
     *
     * @return User
     */
    public function find($employeeId);

    /**
     * Returns tru if an employee is available at a given time
     *
     * @param DateTime $startDate
     * @param DateTime $endDate
     *
     * @return bool
     */
    public function isEmployeeAvailable($startDate, $endDate);

    /**
     * Returns true if an employee can not perform a shift
     * has a conflicting shift or is unavailable during the shift time
     * 
     * @param $employee
     * @param $shift
     *
     * @throws EmployeeNotFoundException
     * @return boolean
     */
    public function cannotPerformShift($employee, $shift);
}
