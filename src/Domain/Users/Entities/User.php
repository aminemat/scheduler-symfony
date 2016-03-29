<?php

namespace Domain\Users\Entities;

use Ramsey\Uuid\Uuid;

class User
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
     * User constructor.
     *
     * @param string   $name
     * @param Position $position
     * @param string   $email
     */
    public function __construct($name, Position $position, $email)
    {
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
