<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Repository;

use UserRoleHierarchy\Entity\User;
use UserRoleHierarchy\Support\Collection;

class UserRepository implements RepositoryInterface
{
    private Collection $dataSource;

    public function __construct(Collection $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function findById(int $id): ?User
    {
        return $this->dataSource->getById($id);
    }
}