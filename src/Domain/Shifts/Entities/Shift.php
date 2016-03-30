<?php

namespace Domain\Shifts\Entities;

use DateTime;
use Domain\Users\Entities\User;
use Domain\Shifts\Entities;
use Ramsey\Uuid\Uuid;

class Shift
{
    /**
     * @var Uuid
     */
    private $id;

    /**
     * @var DateTime
     */
    private $startTime;

    /**
     * @var DateTime
     */
    private $endTime;

    /**
     * @var User
     */
    private $user;

    /**
     * @var ShiftStatus
     */
    private $status;

    /**
     * Shift constructor.
     *
     * @param User     $user
     * @param DateTime $startTime
     * @param DateTime $endTime
     * @param string   $status
     */
    public function __construct(
        User $user,
        DateTime $startTime,
        DateTime $endTime,
        $status = ShiftStatus::SCHEDULED
    ) {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->user = $user;
        $this->status = $status;
    }

    public function markAsPending()
    {
        $this->status == ShiftStatus::PENDING();
    }

    /**
     * @return Uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return ShiftStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
}
