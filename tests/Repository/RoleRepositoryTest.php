<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Tests\Repository;

use PHPUnit\Framework\TestCase;
use UserRoleHierarchy\Data\DataSource;
use UserRoleHierarchy\Entity\Builder\RoleBuilder;
use UserRoleHierarchy\Entity\Role;
use UserRoleHierarchy\Repository\RoleRepository;

class RoleRepositoryTest extends TestCase
{
    public function testFindByIdReturnsExpectedUser(): void
    {
        $data = [
            'id' => 1,
            'name' => 'Role',
            'parent_id' => 0,
        ];

        $mockDataSource = $this->getMockBuilder(DataSource::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findById'])
            ->getMock();

        $mockDataSource->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($data);

        $mockRoleBuilder = $this->getMockBuilder(RoleBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['build'])
            ->getMock();

        $mockRoleBuilder->expects($this->once())
            ->method('build')
            ->with($data)
            ->willReturn(new Role($data['id'], $data['name'], $data['parent_id']));

        $repository = new RoleRepository($mockDataSource, $mockRoleBuilder);

        $this->assertInstanceOf(Role::class, $repository->findById(1));
    }

    public function testFindByInvalidIdReturnsNull(): void
    {
        $mockDataSource = $this->getMockBuilder(DataSource::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findById'])
            ->getMock();

        $mockDataSource->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn([]);

        $mockRoleBuilder = $this->getMockBuilder(RoleBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['build'])
            ->getMock();

        $mockRoleBuilder->expects($this->never())
            ->method('build');

        $repository = new RoleRepository($mockDataSource, $mockRoleBuilder);

        $this->assertNull($repository->findById(1));
    }
}
