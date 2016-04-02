<?php

namespace AppBundle\Persistence\InMemory;

use DateTime;
use Domain\Users\Contracts\UserRepositoryInterface;
use Domain\Users\Entities\User;

class InMemoryUserRepository implements UserRepositoryInterface
{

    /**
     * DoctrineUserRepository constructor.
     *
     * @param string $fixtureFilePath
     */
    public function __construct($fixtureFilePath)
    {
        $this->users = require_once($fixtureFilePath);
    }


    /**
     * Finds an employee by ID
     *
     * @param $userId
     *
     * @return User
     */
    public function find($userId)
    {
        return $this->entityManager->find(User::class, $userId);
    }

    /**
     * Returns true if an employee is available at a given time
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
     * Finds all entities in the repository.
     *
     * @return User[]
     */
    public function findAll()
    {
        return $this->findBy(array());
    }

    /**
     * Finds users by a set of criteria.
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
        $persister = $this->entityManager->getUnitOfWork()->getEntityPersister(User::class);

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }
}
