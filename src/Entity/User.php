<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Entity;

class User extends Entity
{
    private string $name;
    private int $roleId;

    public function __construct(int $id, string $name, int $roleId)
    {
        parent::__construct($id);

        $this->name = $name;
        $this->roleId = $roleId;
    }

    public function jsonSerialize()
    {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'roleId' => $this->roleId
        ]);
    }
}