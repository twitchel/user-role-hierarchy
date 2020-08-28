<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Tests\Entity\Builder;

use PHPUnit\Framework\TestCase;
use UserRoleHierarchy\Entity\Builder\RoleBuilder;

class RoleBuilderTest extends TestCase
{
    public function testRoleEntityBuilt(): void
    {
        $data = [
            'id' => 1,
            'name' => 'Administrator',
            'parent_id' => 0,
        ];

        $role = (new RoleBuilder())->build($data);

        $this->assertEquals($data['id'], $role->getId());
        $this->assertEquals($data['name'], $role->getName());
        $this->assertEquals($data['parent_id'], $role->getParentId());
    }
}
