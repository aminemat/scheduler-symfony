<?php

namespace AppBundle\Persistence\InMemory;

use DateTime;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\Entities\DateRange;
use Domain\Shifts\Entities\Shift;
use Domain\Shifts\Entities\ShiftCollection;
use Domain\Users\Contracts\UserRepositoryInterface;
use Domain\Users\Entities\User;

class InMemoryShiftRepository implements ShiftRepositoryInterface
{
    private $shifts;

    /**
     * InMemoryShiftRepository constructor.
     */
    public function __construct()
    {
        $this->shifts = [];
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
    public function save(Shift $shift)
    {
        $this->shifts[] = $shift;
    }

    /**
     * Returns all shifts for a given date range
     *
     * @param DateRange $dateRange
     * @param int|null  $userId
     *
     * @return ShiftCollection
     */
    public function findAllInDateRange(DateRange $dateRange, $userId = null)
    {
        // TODO: Implement findAllInDateRange() method.
    }

    /**
     * Finds all shifts
     *
     * @return Shift[].
     */
    public function findAll()
    {
        return $this->shifts;
    }

    /**
     * Finds entities by a set of criteria.
     *
     * @param array $criteria
     *
     * @return Shift
     */
    public function findBy(array $criteria)
    {
        foreach ($this->shifts as $shift) {
            foreach ($criteria as $propertyName => $propertyValue) {
                if ($shift->$propertyName == $propertyValue) {
                    return $shift;
                }
            }
        }
        
        return false;
    }    
}
