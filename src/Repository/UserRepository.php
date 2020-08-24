<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Repository;

use UserRoleHierarchy\Entity\User;

class UserRepository extends AbstractRepository
{
    public function findById(int $id): ?User
    {
        return parent::findById($id);
    }
}