<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Entity\Builder;

use UserRoleHierarchy\Entity\Role;

class RoleBuilder implements Builder
{
    public function build(array $data): object
    {
        return new Role($data['id'], $data['name'], $data['parent']);
    }
}