<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Tests\Repository;

use PHPUnit\Framework\TestCase;
use UserRoleHierarchy\Data\DataSource;
use UserRoleHierarchy\Entity\Builder\UserBuilder;
use UserRoleHierarchy\Entity\User;
use UserRoleHierarchy\Repository\UserRepository;

class UserRepositoryTest extends TestCase
{
    public function testFindByIdReturnsExpectedUser(): void
    {
        $data = [
            'id' => 1,
            'name' => 'John Doe',
            'role_id' => 1,
        ];

        $mockDataSource = $this->getMockBuilder(DataSource::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findById'])
            ->getMock();

        $mockDataSource->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($data);

        $mockUserBuilder = $this->getMockBuilder(UserBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['build'])
            ->getMock();

        $mockUserBuilder->expects($this->once())
            ->method('build')
            ->with($data)
            ->willReturn(new User($data['id'], $data['name'], $data['role_id']));

        $repository = new UserRepository($mockDataSource, $mockUserBuilder);

        $this->assertInstanceOf(User::class, $repository->findById(1));
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

        $mockUserBuilder = $this->getMockBuilder(UserBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['build'])
            ->getMock();

        $mockUserBuilder->expects($this->never())
            ->method('build');

        $repository = new UserRepository($mockDataSource, $mockUserBuilder);

        $this->assertNull($repository->findById(1));
    }

    public function testFindByRoleId(): void
    {
        $firstUserData = [
            'id' => 1,
            'name' => 'John Doe',
            'role_id' => 1,
        ];
        $firstUserEntity = new User($firstUserData['id'], $firstUserData['name'], $firstUserData['role_id']);
        $secondUserData = [
            'id' => 2,
            'name' => 'Jimmy Smith',
            'role_id' => 1,
        ];
        $secondUserEntity = new User($secondUserData['id'], $secondUserData['name'], $secondUserData['role_id']);

        $mockDataSource = $this->getMockBuilder(DataSource::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findByField'])
            ->getMock();

        $mockDataSource->expects($this->once())
            ->method('findByField')
            ->with('role_id', 1)
            ->willReturn([$firstUserData, $secondUserData]);

        $mockUserBuilder = $this->getMockBuilder(UserBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['build'])
            ->getMock();

        $mockUserBuilder->method('build')
            ->withConsecutive([$firstUserData], [$secondUserData])
            ->willReturnOnConsecutiveCalls(
                $firstUserEntity,
                $secondUserEntity
            );

        $repository = new UserRepository($mockDataSource, $mockUserBuilder);

        $this->assertEquals([$firstUserEntity, $secondUserEntity], $repository->findByField('role_id', 1));
    }
}