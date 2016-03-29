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
        // TODO: Implement save() method.
    }

    /**
     * Returns all shifts for a given date range
     *
     * @param DateRange $dateRange
     * @param int       $locationId
     * @param int|null  $userId
     *
     * @return ShiftCollection
     */
    public function findAllInDateRange(DateRange $dateRange, $locationId, $userId = null)
    {
        // TODO: Implement findAllInDateRange() method.
    }
}
