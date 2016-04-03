<?php

namespace AppBundle\DataFixtures\Faker\Provider;

use Domain\Employees\PositionEnum;

class EmployeePositionProvider
{
    /**
     * @param string $position
     */
    public static function employeePosition($position)
    {
        return PositionEnum::$position();
    }
}
