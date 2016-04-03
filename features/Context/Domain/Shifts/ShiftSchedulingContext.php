<?php

namespace Feature\Context\Domain\Shifts;

use AppBundle\Event\InMemoryEventDispatcher;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\DateRange;
use Domain\Shifts\Shift;
use Domain\Shifts\ShiftStatus;
use Domain\Shifts\Events\ShiftScheduledEvent;
use Domain\Shifts\Services\ShiftScheduler;
use Domain\Employees\Contracts\EmployeeRepositoryInterface;
use Domain\Employees\Position;
use Domain\Employees\Employee;
use \DateTime;
use PHPUnit_Framework_Assert;

class ShiftSchedulingContext implements Context, SnippetAcceptingContext
{
    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepository;
    /**
     * @var ShiftScheduler
     */
    private $shiftScheduler;
    /**
     * @var ShiftRepositoryInterface
     */
    private $shiftRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * ShiftSchedulingContext constructor.
     *
     * @param EmployeeRepositoryInterface  $employeeRepository
     * @param ShiftRepositoryInterface $shiftRepository
     * @param ShiftScheduler           $shiftScheduler
     * @param InMemoryEventDispatcher $eventDispatcher
     */
    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        ShiftRepositoryInterface $shiftRepository,
        ShiftScheduler $shiftScheduler,
        InMemoryEventDispatcher $eventDispatcher
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->shiftScheduler = $shiftScheduler;
        $this->shiftRepository = $shiftRepository;
        $this->eventDispatcher = $eventDispatcher;
    }


    /**
     * @Given :positionName :name is available
     *
     */
    public function employeeIsAvailable($positionName, $name)
    {
        $this->employeeRepository->save(new Employee($name, new Position($positionName), 'foo@bar.com'));
    }

    /**
     * @When I schedule a shift for :employeeName from :startDate to :endDate
     */
    public function iScheduleAShiftForFromTo($employeeName, $startDate, $endDate)
    {
        $command = new ScheduleShiftCommand(
            $this->getEmployeeByName($employeeName)->getName(),
            new DateRange(
                new DateTime($startDate),
                new DateTime($endDate)
            )
        );
        
        $this->shiftScheduler->schedule($command);
    }

    /**
     * @Then a shift for :employeeName from :dateStart to :dateEnd must be scheduled
     */
    public function aShiftForFromToMustBeSaved($employeeName, $dateStart, $dateEnd)
    {
        print_r($this->shiftRepository->findAll());
        $this->shiftRepository->findBy([
            'employee' 
        ]);
        
    }

    private function getEmployeeByName($employeeName)
    {
        $employees = $this->employeeRepository->findAll();
        
        if ( ! array_key_exists($employeeName, $employees)) {
            throw new \InvalidArgumentException(sprintf('Employee %s does not exist', $employeeName));
        }
        
        return $employees[$employeeName];
    }
    
    /**
     * @Then my schedule should contain :shiftCount shift for employee :employeeName
     */
    public function myScheduleShouldContainShiftForEmployee($shiftCount, $employeeName)
    {
        $this->assertShiftCount($shiftCount);

        /** @var Shift $shift */
        $shift = array_shift($this->shiftRepository->findAll());

        PHPUnit_Framework_Assert::assertEquals($employeeName, $shift->getEmployee()->getName());
        PHPUnit_Framework_Assert::assertEquals(ShiftStatus::SCHEDULED(), $shift->getStatus());
    }
    

    /**
     * @param $shiftCount
     */
    protected function assertShiftCount($shiftCount)
    {
        PHPUnit_Framework_Assert::assertCount(
            (int)$shiftCount,
            $this->shiftRepository->findAll()
        );
    }

    /**
     * @Then a :eventName event must be dispatched
     */
    public function aEventMustBeDispatched($eventName)
    {
        $events = $this->eventDispatcher->getDispatchedEvents();
        
        PHPUnit_Framework_Assert::assertInstanceOf(ShiftScheduledEvent::class, array_shift($events));
    }


}
