<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Entity;

use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    protected int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
