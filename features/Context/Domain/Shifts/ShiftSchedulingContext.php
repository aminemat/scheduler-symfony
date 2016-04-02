<?php

namespace Feature\Context\Domain\Shifts;

use AppBundle\Event\InMemoryEventDispatcher;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\Contracts\EventDispatcherInterface;
use Domain\Shifts\Contracts\ShiftRepositoryInterface;
use Domain\Shifts\Entities\DateRange;
use Domain\Shifts\Entities\Shift;
use Domain\Shifts\Entities\ShiftStatus;
use Domain\Shifts\Events\ShiftScheduledEvent;
use Domain\Shifts\Services\ShiftScheduler;
use Domain\Users\Contracts\UserRepositoryInterface;
use Domain\Users\Entities\Position;
use Domain\Users\Entities\User;
use \DateTime;
use PHPUnit_Framework_Assert;

class ShiftSchedulingContext implements Context, SnippetAcceptingContext
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
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
     * @param UserRepositoryInterface  $userRepository
     * @param ShiftRepositoryInterface $shiftRepository
     * @param ShiftScheduler           $shiftScheduler
     * @param InMemoryEventDispatcher $eventDispatcher
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        ShiftRepositoryInterface $shiftRepository,
        ShiftScheduler $shiftScheduler,
        InMemoryEventDispatcher $eventDispatcher
    )
    {
        $this->userRepository = $userRepository;
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
        $this->userRepository->save(new User($name, new Position($positionName), 'foo@bar.com'));
    }

    /**
     * @When I schedule a shift for :username from :startDate to :endDate
     */
    public function iScheduleAShiftForFromTo($username, $startDate, $endDate)
    {
        $command = new ScheduleShiftCommand(
            $this->getUserByName($username)->getName(),
            new DateRange(
                new DateTime($startDate),
                new DateTime($endDate)
            )
        );
        
        $this->shiftScheduler->schedule($command);
    }

    /**
     * @Then a shift for :username from :dateStart to :dateEnd must be scheduled
     */
    public function aShiftForFromToMustBeSaved($username, $dateStart, $dateEnd)
    {
        print_r($this->shiftRepository->findAll());
        $this->shiftRepository->findBy([
            'user' 
        ]);
        
    }

    private function getUserByName($username)
    {
        $users = $this->userRepository->findAll();
        
        if ( ! array_key_exists($username, $users)) {
            throw new \InvalidArgumentException(sprintf('User %s does not exist', $username));
        }
        
        return $users[$username];
    }
    
    /**
     * @Then my schedule should contain :shiftCount shift for employee :username
     */
    public function myScheduleShouldContainShiftForEmployee($shiftCount, $username)
    {
        $this->assertShiftCount($shiftCount);

        /** @var Shift $shift */
        $shift = array_shift($this->shiftRepository->findAll());

        PHPUnit_Framework_Assert::assertEquals($username, $shift->getUser()->getName());
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
