<?php

namespace Domain\Employees;

use MyCLabs\Enum\Enum;

class PositionEnum extends Enum
{
    const MANAGER = 'manager';
    const CASHIER = 'cashier';
    const SALESMAN = 'salesman';
    const BUYER = 'buyer';
    const MERCHANDISER = 'merchandiser';
}
