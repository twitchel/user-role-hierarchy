<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Tests\Service;

use PHPUnit\Framework\TestCase;
use UserRoleHierarchy\Entity\Role;
use UserRoleHierarchy\Entity\User;
use UserRoleHierarchy\Repository\RoleRepository;
use UserRoleHierarchy\Repository\UserRepository;
use UserRoleHierarchy\Service\UserRoleService;

class UserRoleServiceTest extends TestCase
{
    /** @dataProvider providerGetUserById */
    public function testGetUserByIdReturnsExpectedUser($userId, $expected): void
    {
        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findById'])
            ->getMock();

        $userRepository->expects($this->once())
            ->method('findById')
            ->with($userId)
            ->willReturn($expected);

        $roleRepository = $this->getMockBuilder(RoleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $service = new UserRoleService($userRepository, $roleRepository);

        $this->assertEquals($expected, $service->getUserById($userId));
    }

    public function testGetUserSubordinates(): void
    {
        $secondTierRole = new Role(2, 'Second Tier', 1);
        $thirdTierRole = new Role(3, 'Third Tier', 2);
        $thirdTierRoleRepeat = new Role(4, 'Third Tier Repeat', 2);

        $queriedUser = new User(1, 'First Tier', 1);
        $expectedSubordinates = [
            new User(2, 'Second Tier Role 2', 2),
            new User(3, 'Third Tier Role 3', 3),
            new User(4, 'Third Tier Role 4', 4),
            new User(5, 'Third Tier Role 4 Repeat', 4)
        ];

        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findByField'])
            ->getMock();

        $userRepository->method('findByField')
            ->withConsecutive(['role_id', 2], ['role_id', 3], ['role_id', 4])
            ->willReturnOnConsecutiveCalls(
                [$expectedSubordinates[0]],
                [$expectedSubordinates[1]],
                [$expectedSubordinates[2], $expectedSubordinates[3]]
            );

        $roleRepository = $this->getMockBuilder(RoleRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findByField'])
            ->getMock();

        $roleRepository->method('findByField')
            ->withConsecutive(['parent_id', 1], ['parent_id', 2], ['parent_id', 3], ['parent_id', 4], ['parent_id', 4])
            ->willReturnOnConsecutiveCalls([$secondTierRole], [$thirdTierRole, $thirdTierRoleRepeat], [], [], []);

        $service = new UserRoleService($userRepository, $roleRepository);

        $this->assertEquals($expectedSubordinates, $service->getUserSubordinates($queriedUser));
    }

    public function providerGetUserById(): array
    {
        return [
            [999, null],
            [1, new User(1, 'Adam Admin', 1)],
        ];
    }
}
