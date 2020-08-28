<?php

declare(strict_types=1);

namespace UserRoleHierarchy\Entity\Builder;

interface Builder
{
    public function build(array $data): object;
}
