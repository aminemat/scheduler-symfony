<?php

namespace Domain\Shifts\Services;

use Domain\Shifts\Commands\GetShiftsCommand;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\Entities\ShiftCollection;

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
     * @param GetShiftsCommand $getShiftsCommand
     *
     * @return ShiftCollection
     */
    public function getShifts(GetShiftsCommand $getShiftsCommand)
    {
        return $this->shiftRepository->findAllInDateRange(
            $getShiftsCommand->getDateRange(),
            $getShiftsCommand->getLocationId(),
            $getShiftsCommand->getEmployeeId()
        );
    }
}
