<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Tests\Entity\Builder;

use PHPUnit\Framework\TestCase;
use UserRoleHierarchy\Entity\Builder\UserBuilder;

class UserBuilderTest extends TestCase
{
    public function testUserEntityBuilt(): void
    {
        $data = [
            'id' => 1,
            'name' => 'John Doe',
            'role_id' => 1,
        ];

        $user = (new UserBuilder())->build($data);

        $this->assertEquals($data['id'], $user->getId());
        $this->assertEquals($data['name'], $user->getName());
        $this->assertEquals($data['role_id'], $user->getRoleId());
    }
}
