<?php

namespace AppBundle\Persistence\InMemory;

use DateTime;
use Domain\Users\Contracts\UserRepositoryInterface;
use Domain\Users\Entities\User;

class InMemoryUserRepository implements UserRepositoryInterface
{
    /**
     * @var array
     */
    private $users;

    /**
     * InMemoryUserRepository constructor.
     */
    public function __construct()
    {
        $this->users = [];
    }


    /**
     * Finds a user by ID
     *
     * @param $userId
     *
     * @return User
     */
    public function find($userId)
    {
        return $this->users[$userId];
    }

    /**
     * Finds all users
     *
     * @return array The entities.
     */
    public function findAll()
    {
        return $this->users;
    }

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
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        // TODO: Implement findBy() method.
    }

    /**
     * Returns true if a user is available at a given time
     *
     * @param User     $user
     * @param DateTime $startDate
     * @param DateTime $endDate
     *
     * @return bool
     */
    public function isAvailable(User $user, $startDate, $endDate)
    {
        return true;
    }

    /**
     * Saves a user
     *
     * @param User $user
     *
     * @return void
     */
    public function save(User $user)
    {
        $this->users[(string)$user->getName()] = $user;
    }
}
