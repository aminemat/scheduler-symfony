<?php

namespace Test\Domain\Shifts\Command;

use DateTime;
use Domain\Shifts\Commands\ScheduleShiftCommand;
use Domain\Shifts\DateRange;
use \InvalidArgumentException;
use \PHPUnit_Framework_TestCase;

class ScheduleShiftCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function test_throws_an_exception_when_startdate_precedes_enddate()
    {
        $this->expectException(InvalidArgumentException::class);

        new ScheduleShiftCommand(
            'foo',
            new DateRange(
                new DateTime('January 1st 2016 3:00 p.m'),
                new DateTime('January 1st 2016 1:00 p.m')
            )
        );
    }
}
