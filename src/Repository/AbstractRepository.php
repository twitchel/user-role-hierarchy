<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Repository;

use UserRoleHierarchy\Data\DataSource;
use UserRoleHierarchy\Entity\Builder\Builder;

abstract class AbstractRepository
{
    protected DataSource $dataSource;
    protected Builder $builder;

    public function __construct(DataSource $dataSource, Builder $builder)
    {
        $this->dataSource = $dataSource;
        $this->builder = $builder;
    }

    public function findById(int $id): ?object
    {
        $item = $this->dataSource->findById($id);

        return !empty($item) ? $this->buildEntity($item) : null;
    }

    public function findByField(string $field, $value): array
    {
        $items = $this->dataSource->findByField($field, $value);

        $entities = [];
        foreach ($items as $item) {
            $entities[] = $this->buildEntity($item);
        }

        return $entities;
    }

    protected function buildEntity(array $data): object
    {
        return $this->builder->build($data);
    }
}
