<?php

namespace Domain\Shifts\Services;

use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Users\Contracts\EmployeeRepositoryInterface;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\Entities\Shift;
use Domain\Shifts\Events\ShiftScheduledEvent;


class ShiftScheduler
{
    /**
     * @var ShiftRepositoryInterface
     */
    private $shiftRepository;
    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * ShiftScheduler constructor.
     *
     * @param ShiftRepositoryInterface    $shiftRepository
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param EventDispatcherInterface    $eventDispatcher
     */
    public function __construct(
        ShiftRepositoryInterface $shiftRepository,
        EmployeeRepositoryInterface $employeeRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->shiftRepository = $shiftRepository;
        $this->employeeRepository = $employeeRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Schedules a shift for an employee
     *
     * @param ScheduleShiftCommand $scheduleShiftCommand
     *
     * @return bool
     */
    public function schedule(ScheduleShiftCommand $scheduleShiftCommand)
    {
        $user = $this->employeeRepository->find($scheduleShiftCommand->getEmployeeId());
        
        $shift = new Shift($user, $scheduleShiftCommand->from(), $scheduleShiftCommand->to());

        if ($this->employeeRepository->cannotPerformShift($user, $shift)) {
            $shift->markAsPending();
        }

        $this->shiftRepository->save($shift);
        $this->eventDispatcher->dispatch('shift.scheduled', new ShiftScheduledEvent($shift));
    }
}
