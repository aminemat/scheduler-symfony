<?php

namespace Domain\Employees;

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
     * @param PositionEnum $name
     * @param null $id
     */
    public function __construct(PositionEnum $name, $id = null)
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
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
