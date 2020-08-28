<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Tests\Data;

use PHPUnit\Framework\TestCase;
use UserRoleHierarchy\Data\DataSource;

class DataSourceTest extends TestCase
{
    /** @dataProvider providerTestFindById */
    public function testFindById($id, $expected): void
    {
        $testData = [
            ['id' => 1, 'name' => 'item'],
        ];

        $dataSource = new DataSource($testData);

        $this->assertEquals($expected, $dataSource->findById($id));
    }

    public function testFindByField(): void
    {
        $expectedRow = ['correctFieldName' => 'correctValue'];

        $data = [
            $expectedRow,
            $expectedRow,
            ['incorrectFieldName' => 'correctValue'],
            ['correctFieldName' => 'incorrectValue'],
        ];

        $dataSource = new DataSource($data);

        $this->assertEquals([
            $expectedRow,
            $expectedRow,
        ], $dataSource->findByField('correctFieldName', 'correctValue'));
    }

    public function providerTestFindById(): array
    {
        return [
            [1, ['id' => 1, 'name' => 'item']],
            [999, null]
        ];
    }
}