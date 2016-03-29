<?php

namespace Domain\Users\Contracts;

use DateTime;
use Domain\Users\Contracts\Exception\UserNotFoundException;
use Domain\Users\Entities\User;

interface UserRepositoryInterface
{
    /**
     * Finds an employee by ID
     *
     * @param $userId
     *
     * @return User
     */
    public function find($userId);

    /**
     * Returns true if an employee is available at a given time
     *
     * @param User     $user
     * @param DateTime $startDate
     * @param DateTime $endDate
     *
     * @return bool
     */
    public function isAvailable(User $user, $startDate, $endDate);
}
