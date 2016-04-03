<?php

namespace AppBundle\Persistence\Doctrine;

use DateTime;
use Doctrine\ORM\EntityManager;
use Domain\Employees\Contracts\EmployeeRepositoryInterface;
use Domain\Employees\Entities\Employee;

class DoctrineEmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DoctrineEmployeeRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Finds an employee by ID
     *
     * @param $employeeId
     *
     * @return Employee
     */
    public function find($employeeId)
    {
        return $this->entityManager->find(Employee::class, $employeeId);
    }

    /**
     * Returns true if an employee is available at a given time
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
     * Finds all entities in the repository.
     *
     * @return Employee[]
     */
    public function findAll()
    {
        return $this->findBy(array());
    }

    /**
     * Finds employees by a set of criteria.
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
        $persister = $this->entityManager->getUnitOfWork()->getEntityPersister(Employee::class);

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
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
        // TODO: Implement save() method.
    }}
