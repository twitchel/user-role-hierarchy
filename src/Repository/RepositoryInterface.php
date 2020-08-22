<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Repository;

interface RepositoryInterface
{
    public function findById(int $id): ?object;
}