<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Entity\Builder;

use UserRoleHierarchy\Entity\User;

class UserBuilder implements Builder
{
    public function build(array $data): User
    {
        return new User((int) $data['id'], $data['name'], (int) $data['role_id']);
    }
}
