<?php

namespace Domain\Shifts\Services;

use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Shifts\Services\Exception\UserNotAvailableException;
use Domain\Users\Contracts\Exception\UserNotFoundException;
use Domain\Users\Contracts\UserRepositoryInterface;
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
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * ShiftScheduler constructor.
     *
     * @param ShiftRepositoryInterface $shiftRepository
     * @param UserRepositoryInterface  $userRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        ShiftRepositoryInterface $shiftRepository,
        UserRepositoryInterface $userRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->shiftRepository = $shiftRepository;
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Schedules a shift for an employee
     *
     * @param ScheduleShiftCommand $scheduleShiftCommand
     *
     * @return bool
     * @throws UserNotAvailableException
     * @throws UserNotFoundException
     */
    public function schedule(ScheduleShiftCommand $scheduleShiftCommand)
    {
        $startDate = $scheduleShiftCommand->to();
        $endDate = $scheduleShiftCommand->from();
        
        if ( ! $user = $this->userRepository->find($scheduleShiftCommand->getUserId())) {
            throw new UserNotFoundException();
        }

        if ( ! $this->userRepository->isAvailable($user, $startDate, $endDate)) {
            throw new UserNotAvailableException();
        }
        
        $shift = new Shift($user, $startDate, $endDate);
        $this->shiftRepository->save($shift);
        
        $this->eventDispatcher->dispatch(new ShiftScheduledEvent($shift));
    }
}
