<?php

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
}