<?php

namespace Test\Domain\Shifts\Services;

use DateTime;
use Domain\Employees\PositionEnum;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\DateRange;
use Domain\Shifts\Shift;
use Domain\Shifts\Events\ShiftScheduledEvent;
use Domain\Shifts\Services\Exception\EmployeeNotAvailableException;
use Domain\Shifts\Services\ShiftScheduler;
use Domain\Employees\Contracts\Exception\EmployeeNotFoundException;
use Domain\Employees\Contracts\EmployeeRepositoryInterface;
use Domain\Employees\Position;
use Domain\Employees\Employee;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @property \PHPUnit_Framework_MockObject_MockObject eventDispatcherStub
 */
class ShiftSchedulerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $employeeRepositoryStub;

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
        $this->employeeRepositoryStub = $this->getMockBuilder(EmployeeRepositoryInterface::class)->getMock();
        $this->shiftRepositoryStub = $this->getMockBuilder(ShiftRepositoryInterface::class)->getMock();
        $this->eventDispatcherStub = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        
        $this->shiftScheduler = new ShiftScheduler(
            $this->shiftRepositoryStub,
            $this->employeeRepositoryStub,
            $this->eventDispatcherStub
        );
    }
    
    /**
     * @test
     */
    public function throws_an_employee_not_found_exception_if_invalid_employee()
    {
        $this->expectException(EmployeeNotFoundException::class);
        
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
        $employeeMock = new Employee('foo', new Position(PositionEnum::CASHIER()), 'foo@bar.com');
        $startDate = new DateTime('January 1st 2016 1:00 p.m CST');
        $endDate = new DateTime('January 1st 2016 6:00 p.m CST');
        
        $shift = new Shift($employeeMock, $startDate, $endDate);
        
        $this->employeeRepositoryStub->method('find')->willReturn($employeeMock);
        $this->employeeRepositoryStub->method('isAvailable')->willReturn(true);        
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

    /**
     * @test
     */
    public function marks_shift_as_pending_when_the_employee_is_no_available()
    {
        $employeeMock = new Employee('foo', new Position(PositionEnum::CASHIER()), 'foo@bar.com');
        $startDate = new DateTime('January 1st 2016 1:00 p.m CST');
        $endDate = new DateTime('January 1st 2016 6:00 p.m CST');

        $shift = new Shift($employeeMock, $startDate, $endDate);

        $this->employeeRepositoryStub->method('find')->willReturn($employeeMock);
        $this->employeeRepositoryStub->method('isAvailable')->willReturn(false);
        
        $shift->markAsPending();
        
        $this->shiftRepositoryStub->method('save')->with($shift);
        

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
