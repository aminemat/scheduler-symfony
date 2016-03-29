<?php

namespace AppBundle\Persistence\Doctrine;

use DateTime;
use Doctrine\ORM\EntityManager;
use Domain\Users\Contracts\UserRepositoryInterface;
use Domain\Users\Entities\User;

class DoctrineUserRepository implements UserRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DoctrineUserRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
        // TODO: Implement find() method.
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
        // TODO: Implement isAvailable() method.
    }
}
