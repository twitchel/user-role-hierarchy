<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Entity;

class Role
{
    private $id;
    private $name;
    private $parentId;

    public function __construct(int $id, string $name, int $parentId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }
}
