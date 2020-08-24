<?php
declare(strict_types=1);

namespace UserRoleHierarchy\Support;

use UserRoleHierarchy\Entity\Entity;

class Collection
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(int $id): ?Entity
    {
        $matches = array_filter($this->data, static function (Entity $item) use ($id) {
            return $item->getId() === $id;
        });

        return count($matches) === 1 ? current($matches) : null;
    }
}