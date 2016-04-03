<?php

namespace Domain\Shifts\Contracts;

use Domain\Shifts\Entities\DateRange;
use Domain\Shifts\Entities\Shift;
use Domain\Shifts\Entities\ShiftCollection;

interface ShiftRepositoryInterface
{
    /**
     * Finds a shift by ID
     *
     * @return Shift
     */
    public function find();

    /**
     * Finds all shifts
     *
     * @return Shift[].
     */
    public function findAll();    

    /**
     * Returns true if a shift exists for an employee at a given time
     *
     * @param Shift $shift
     *
     * @return bool
     */
    public function shiftExists(Shift $shift);

    /**
     * Persists a Shift
     *
     * @param $shift
     *
     * @return mixed
     */
    public function save(Shift $shift);

    /**
     * Returns all shifts for a given date range
     *
     * @param DateRange $dateRange
     * @param int|null  $employeeId
     *
     * @return ShiftCollection
     */
    public function findAllInDateRange(DateRange $dateRange, $employeeId = null);

    /**
     * @param array $criteria
     *
     * @return mixed
     */
    public function findBy(array $criteria);
}
