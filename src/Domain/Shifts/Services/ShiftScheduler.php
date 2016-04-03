<?php

namespace Domain\Shifts\Services;

use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Shifts\Services\Exception\EmployeeNotAvailableException;
use Domain\Employees\Contracts\Exception\EmployeeNotFoundException;
use Domain\Employees\Contracts\EmployeeRepositoryInterface;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\Shift;
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
     * @param ShiftRepositoryInterface $shiftRepository
     * @param EmployeeRepositoryInterface  $employeeRepository
     * @param EventDispatcherInterface $eventDispatcher
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
     * @throws EmployeeNotAvailableException
     * @throws EmployeeNotFoundException
     */
    public function schedule(ScheduleShiftCommand $scheduleShiftCommand)
    {
        $startDate = $scheduleShiftCommand->from();
        $endDate = $scheduleShiftCommand->to();
        
        if ( ! $employee = $this->employeeRepository->find($scheduleShiftCommand->getEmployeeId())) {
            throw new EmployeeNotFoundException();
        }

        if ( ! $this->employeeRepository->isAvailable($employee, $startDate, $endDate)) {
            throw new EmployeeNotAvailableException();
        }
        
        $shift = new Shift($employee, $startDate, $endDate);
        $this->shiftRepository->save($shift);
        
        $this->eventDispatcher->dispatch(new ShiftScheduledEvent($shift));
    }
}
