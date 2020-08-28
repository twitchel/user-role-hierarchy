<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Tests\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\StreamOutput;
use UserRoleHierarchy\Command\GetUserCommand;
use UserRoleHierarchy\Command\GetUserSubordinatesCommand;
use UserRoleHierarchy\Entity\User;
use UserRoleHierarchy\Repository\RoleRepository;
use UserRoleHierarchy\Repository\UserRepository;
use UserRoleHierarchy\Service\UserRoleService;

class GetUserSubordinatesCommandTest extends TestCase
{
    public function testGetUserSubordinatesCommandExecutesSuccessfully(): void
    {
        $user = new User(1, 'Adam Admin', 1);

        $subordinates = [
            new User(2, 'Subordinate 1', 2),
            new User(3, 'Subordinate 2', 3),
        ];

        $userRoleService = $this->getMockBuilder(UserRoleService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getUserById', 'getUserSubordinates'])
            ->getMock();

        $userRoleService->expects($this->once())
            ->method('getUserById')
            ->with(1)
            ->willReturn($user);

        $userRoleService->expects($this->once())
            ->method('getUserSubordinates')
            ->with($user)
            ->willReturn($subordinates);


        $mockInput = $this->getMockBuilder(ArgvInput::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getArgument'])
            ->getMock();

        $mockInput->expects($this->once())
            ->method('getArgument')
            ->with('user-id')
            ->willReturn('1');

        $mockOutput = $this->getMockBuilder(StreamOutput::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['write'])
            ->getMock();

        $mockOutput->expects($this->once())
            ->method('write')
            ->with(json_encode($subordinates));

        $command = new GetUserSubordinatesCommand($userRoleService);
        $this->assertEquals(0, $command->execute($mockInput, $mockOutput));
    }

    public function testGetUserSubordinatesCommandExecutesWithInvalidUser(): void
    {
        $userRoleService = $this->getMockBuilder(UserRoleService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getUserById', 'getUserSubordinates'])
            ->getMock();

        $userRoleService->expects($this->once())
            ->method('getUserById')
            ->with(999)
            ->willReturn(null);

        $userRoleService->expects($this->never())
            ->method('getUserSubordinates');


        $mockInput = $this->getMockBuilder(ArgvInput::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getArgument'])
            ->getMock();

        $mockInput->expects($this->once())
            ->method('getArgument')
            ->with('user-id')
            ->willReturn('999');

        $mockOutput = $this->getMockBuilder(StreamOutput::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['write'])
            ->getMock();

        $mockOutput->expects($this->never())
            ->method('write');

        $command = new GetUserSubordinatesCommand($userRoleService);
        $this->assertEquals(1, $command->execute($mockInput, $mockOutput));
    }
}
