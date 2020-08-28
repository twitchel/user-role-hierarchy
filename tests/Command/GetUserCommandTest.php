<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Tests\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\StreamOutput;
use UserRoleHierarchy\Command\GetUserCommand;
use UserRoleHierarchy\Entity\User;
use UserRoleHierarchy\Service\UserRoleService;

class GetUserCommandTest extends TestCase
{
    public function testGetUserCommandExecutesWithValidUser(): void
    {
        $user = new User(1, 'Adam Admin', 1);

        $userRoleService = $this->getMockBuilder(UserRoleService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getUserById'])
            ->getMock();

        $userRoleService->expects($this->once())
            ->method('getUserById')
            ->with(1)
            ->willReturn($user);


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
            ->with(json_encode($user));

        $command = new GetUserCommand($userRoleService);
        $this->assertEquals(0, $command->execute($mockInput, $mockOutput));
    }

    public function testGetUserCommandExecutesWithInvalidUser(): void
    {
        $userRoleService = $this->getMockBuilder(UserRoleService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getUserById'])
            ->getMock();

        $userRoleService->expects($this->once())
            ->method('getUserById')
            ->with(999)
            ->willReturn(null);


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

        $command = new GetUserCommand($userRoleService);
        $this->assertEquals(1, $command->execute($mockInput, $mockOutput));
    }
}
