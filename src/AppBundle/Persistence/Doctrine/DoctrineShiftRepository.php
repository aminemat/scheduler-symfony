<?php

namespace AppBundle\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\DateRange;
use Domain\Shifts\Shift;


class DoctrineShiftRepository implements ShiftRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DoctrineShiftRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Finds a shift by ID
     *
     * @return Shift
     */
    public function find()
    {
        // TODO: Implement find() method.
    }

    /**
     * Returns true if a shift exists for an employee at a given time
     *
     * @param Shift $shift
     *
     * @return bool
     */
    public function shiftExists(Shift $shift)
    {
        // TODO: Implement shiftExists() method.
    }

    /**
     * Persists a Shift
     *
     * @param $shift
     *
     * @return mixed
     */
    public function save($shift)
    {
        $this->entityManager->persist($shift);
        $this->entityManager->flush();
    }

    /**
     * Returns all shifts for a given date range
     *
     * @param DateRange $dateRange
     * @param int|null  $employeeId
     *
     * @return Shift[]
     */
    public function findAllInDateRange(DateRange $dateRange, $employeeId = null)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('s')
            ->from('Domain\Shifts\Entities\Shift', 's')
            ->where('s.startTime > :startDate')
            ->andWhere('s.endTime < :endDate')
            ->setParameter(':startDate', $dateRange->getStartDate())
            ->setParameter(':endDate', $dateRange->getEndDate())
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds all shifts
     *
     * @return Shift[].
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param array $criteria
     *
     * @return mixed
     */
    public function findBy(array $criteria)
    {
        // TODO: Implement findBy() method.
    }
}
