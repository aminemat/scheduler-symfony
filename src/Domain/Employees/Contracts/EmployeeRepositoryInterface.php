<?php

namespace Domain\Employees\Contracts;

use DateTime;
use Domain\Employees\Employee;

interface EmployeeRepositoryInterface
{
    /**
     * Finds a employee by ID
     *
     * @param $employeeId
     *
     * @return Employee
     */
    public function find($employeeId);

    /**
     * Finds all employees
     *
     * @return Employee[]
     */
    public function findAll();

    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    
    /**
     * Returns true if a employee is available at a given time
     *
     * @param Employee $employee
     * @param DateTime $startDate
     * @param DateTime $endDate
     *
     * @return bool
     */
    public function isAvailable(Employee $employee, $startDate, $endDate);

    /**
     * Saves a employee
     * 
*@param Employee $employee
     *
     * @return void
     */
    public function save(Employee $employee);
}
