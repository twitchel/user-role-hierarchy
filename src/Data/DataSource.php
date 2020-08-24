<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Data;

class DataSource
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function findById(int $id): ?array
    {
        $matches = $this->findByField('id', $id);

        return count($matches) === 1 ? current($matches) : null;
    }

    public function findByField(string $field, $value): array
    {
        return array_filter($this->data, static function (array $item) use ($field, $value) {
            return array_key_exists($field, $item) && $item[$field] === $value;
        });
    }
}