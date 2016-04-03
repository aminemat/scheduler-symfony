<?php

namespace Domain\Employees\Entities;

use Ramsey\Uuid\Uuid;

class Position
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
     * Position constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
