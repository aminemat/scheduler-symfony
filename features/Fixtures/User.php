<?php


use Domain\Users\Entities\Position;
use Domain\Users\Entities\Employee;


return [
    new Employee('John Doe', new Position('manager'), 'johndoe@foobar.com'),
];
