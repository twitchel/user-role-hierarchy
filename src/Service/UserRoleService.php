<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Service;

use UserRoleHierarchy\Entity\User;
use UserRoleHierarchy\Repository\RoleRepository;
use UserRoleHierarchy\Repository\UserRepository;

class UserRoleService
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function getUserSubordinates(User $user): array
    {
        $subordinateRoles = $this->getSubordinateRoles($user->getRoleId());

        $subordinates = [];
        foreach ($subordinateRoles as $role) {
            $roleSubordinates = $this->getUsersByRole($role->getId());
            $subordinates[] = $roleSubordinates;

            foreach ($roleSubordinates as $roleSubordinate) {
                $subordinates[] = $this->getUserSubordinates($roleSubordinate);
            }
        }

        return array_merge([], ...$subordinates);
    }

    protected function getSubordinateRoles(int $roleId): array
    {
        return $this->roleRepository->findByField('parent_id', $roleId);
    }

    protected function getUsersByRole(int $roleId): array
    {
        return $this->userRepository->findByField('role_id', $roleId);
    }
}