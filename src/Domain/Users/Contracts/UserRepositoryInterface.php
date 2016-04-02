<?php

namespace Domain\Users\Contracts;

use DateTime;
use Domain\Users\Entities\User;

interface UserRepositoryInterface
{
    /**
     * Finds a user by ID
     *
     * @param $userId
     *
     * @return User
     */
    public function find($userId);

    /**
     * Finds all users
     *
     * @return User[]
     */
    public function findAll();

    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    
    /**
     * Returns true if a user is available at a given time
     *
     * @param User     $user
     * @param DateTime $startDate
     * @param DateTime $endDate
     *
     * @return bool
     */
    public function isAvailable(User $user, $startDate, $endDate);

    /**
     * Saves a user
     * @param User $user
     *
     * @return void
     */
    public function save(User $user);
}
