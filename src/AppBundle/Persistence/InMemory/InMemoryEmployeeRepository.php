<?php

namespace AppBundle\Persistence\InMemory;

use DateTime;
use Domain\Employees\Contracts\EmployeeRepositoryInterface;
use Domain\Employees\Employee;

class InMemoryEmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @var array
     */
    private $employees;

    /**
     * InMemoryEmployeeRepository constructor.
     */
    public function __construct()
    {
        $this->employees = [];
    }


    /**
     * Finds a employee by ID
     *
     * @param $employeeId
     *
     * @return Employee
     */
    public function find($employeeId)
    {
        return $this->employees[$employeeId];
    }

    /**
     * Finds all employees
     *
     * @return array The entities.
     */
    public function findAll()
    {
        return $this->employees;
    }

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
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        // TODO: Implement findBy() method.
    }

    /**
     * Returns true if a employee is available at a given time
     *
     * @param Employee $employee
     * @param DateTime $startDate
     * @param DateTime $endDate
     *
     * @return bool
     */
    public function isAvailable(Employee $employee, $startDate, $endDate)
    {
        return true;
    }

    /**
     * Saves a employee
     *
     * @param Employee $employee
     *
     * @return void
     */
    public function save(Employee $employee)
    {
        $this->employees[(string)$employee->getName()] = $employee;
    }
}
