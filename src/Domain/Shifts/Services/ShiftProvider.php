<?php

namespace Domain\Shifts\Services;

use Domain\Shifts\Commands\GetShiftsCommand;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\DateRange;
use Domain\Shifts\ShiftCollection;

class ShiftProvider
{
    /**
     * @var ShiftRepositoryInterface
     */
    private $shiftRepository;

    /**
     * ShiftProvider constructor.
     *
     * @param ShiftRepositoryInterface $shiftRepository
     */
    public function __construct(ShiftRepositoryInterface $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    /**
     * @param DateRange $dateRange
     * @return ShiftCollection
     *
     */
    public function getShifts(DateRange $dateRange)
    {
        return $this->shiftRepository->findAllInDateRange(
            $dateRange
        );
    }
}
