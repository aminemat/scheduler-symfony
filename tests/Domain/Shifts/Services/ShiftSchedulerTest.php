<?php

namespace Test\Domain\Shifts\Services;

use DateTime;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\Entities\DateRange;
use Domain\Shifts\Entities\Shift;
use Domain\Shifts\Events\ShiftScheduledEvent;
use Domain\Shifts\Services\Exception\UserNotAvailableException;
use Domain\Shifts\Services\ShiftScheduler;
use Domain\Users\Contracts\Exception\UserNotFoundException;
use Domain\Users\Contracts\UserRepositoryInterface;
use Domain\Users\Entities\Position;
use Domain\Users\Entities\User;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @property \PHPUnit_Framework_MockObject_MockObject eventDispatcherStub
 */
class ShiftSchedulerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $userRepositoryStub;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $shiftRepositoryStub;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $eventDispatcherStub;

    /**
     * @var ShiftScheduler
     */
    private $shiftScheduler;
    

    public function setup()
    {
        $this->userRepositoryStub = $this->getMockBuilder(UserRepositoryInterface::class)->getMock();
        $this->shiftRepositoryStub = $this->getMockBuilder(ShiftRepositoryInterface::class)->getMock();
        $this->eventDispatcherStub = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        
        $this->shiftScheduler = new ShiftScheduler(
            $this->shiftRepositoryStub,
            $this->userRepositoryStub,
            $this->eventDispatcherStub
        );
    }
    
    /**
     * @test
     */
    public function throws_a_user_not_found_exception_if_invalid_user()
    {
        $this->expectException(UserNotFoundException::class);
        
        $command = new ScheduleShiftCommand(
            'foo',
            new DateRange(
                new DateTime('January 1st 2016 1:00 p.m'),
                new DateTime('January 1st 2016 3:00 p.m')            
            )
        );
        
        $this->shiftScheduler->schedule($command);
    }

    /**
     * @test
     */
    public function throws_a_user_not_available_exception_if_user_unavailable()
    {
        $this->expectException(UserNotAvailableException::class);

        $this->userRepositoryStub->method('find')->willReturn(new User('foo', new Position('Cashier'), 'foo@bar.com'));
        $this->userRepositoryStub->method('isAvailable')->willReturn(false);

        $command = new ScheduleShiftCommand(
            'foo',
            new DateRange(
                new DateTime('January 1st 2016 1:00 p.m'),
                new DateTime('January 1st 2016 3:00 p.m')
            )
        );

        $this->shiftScheduler->schedule($command);
    }

    /**
     * @test
     */
    public function dispatches_an_event_after_a_shift_is_scheduled()
    {
        $userMock = new User('foo', new Position('Cashier'), 'foo@bar.com');
        $startDate = new DateTime('January 1st 2016 1:00 p.m CST');
        $endDate = new DateTime('January 1st 2016 6:00 p.m CST');
        
        $shift = new Shift($userMock, $startDate, $endDate);
        
        $this->userRepositoryStub->method('find')->willReturn($userMock);
        $this->userRepositoryStub->method('isAvailable')->willReturn(true);        
        $this->eventDispatcherStub->method('dispatch')->with(new ShiftScheduledEvent($shift));
        
        $command = new ScheduleShiftCommand(
            'foo',
            new DateRange(
                $startDate,
                $endDate
            )
        );
        $this->shiftScheduler->schedule($command);
    }

}
