<?php

namespace Feature\Context\Domain\Shifts;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Domain\Users\Contracts\UserRepositoryInterface;

class ShiftSchedulingContext implements Context, SnippetAcceptingContext
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * ShiftSchedulingContext constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @Given employee :arg1 is available
     */
    public function employeeIsAvailable($arg1)
    {
        
    }

    /**
     * @When I schedule a shift for :arg1 from :arg2 to :arg3
     */
    public function iScheduleAShiftForFromTo($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @Then a shift for :arg1 from :arg2 to :arg3 must be saved
     */
    public function aShiftForFromToMustBeSaved($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }
    

}
