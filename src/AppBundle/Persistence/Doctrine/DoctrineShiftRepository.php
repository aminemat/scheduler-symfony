<?php

namespace AppBundle\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\Entities\DateRange;
use Domain\Shifts\Entities\Shift;


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
     * @param int|null  $userId
     *
     * @return Shift[]
     */
    public function findAllInDateRange(DateRange $dateRange, $userId = null)
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
}
