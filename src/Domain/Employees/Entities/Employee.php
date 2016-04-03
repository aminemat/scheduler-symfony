<?php

namespace Domain\Employees\Entities;

use Ramsey\Uuid\Uuid;

class Employee
{
    /**
     * @var Uuid
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Position
     */
    private $position;

    /**
     * @var string
     */
    private $email;

    /**
     * Employee constructor.
     *
     * @param string   $name
     * @param Position $position
     * @param string   $email
     * @param Uuid|null $id
     */
    public function __construct($name, Position $position, $email, $id = null)
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
        $this->name = $name;
        $this->position = $position;
        $this->email = $email;
    }

    /**
     * @return Uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
