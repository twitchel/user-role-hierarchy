<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Repository;

use UserRoleHierarchy\Entity\Role;

class RoleRepository extends AbstractRepository
{
    public function findById(int $id): ?Role
    {
        return parent::findById($id);
    }
}
