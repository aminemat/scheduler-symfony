<?php


use Domain\Users\Entities\Position;
use Domain\Users\Entities\User;


return [
    new User('John Doe', new Position('manager'), 'johndoe@foobar.com'),
];
