<?php
declare(strict_types=1);

use Pimple\Container;
use Symfony\Component\Console\Application;
use UserRoleHierarchy\Command\GetUserCommand;
use UserRoleHierarchy\Data\DataSource;
use UserRoleHierarchy\Entity\Builder\RoleBuilder;
use UserRoleHierarchy\Entity\Builder\UserBuilder;
use UserRoleHierarchy\Repository\RoleRepository;
use UserRoleHierarchy\Repository\UserRepository;
use UserRoleHierarchy\Service\UserRoleService;

$container = new Container();

$container[Application::class] = static function (Container $container): Application {
    $application = new Application('User Role Hierarchy');

    $application->add(new GetUserCommand($container[UserRoleService::class]));

    return $application;
};

$container[UserRoleService::class] = static function (Container $container): UserRoleService {
    return new UserRoleService($container[UserRepository::class], $container[RoleRepository::class]);
};

$container[UserRepository::class] = static function (Container $container): UserRepository {
    $rawData = file_get_contents(__DIR__ . '/../data/users.json');

    $dataSource = new DataSource(json_decode($rawData, true));
    return new UserRepository($dataSource, new UserBuilder());
};

$container[RoleRepository::class] = static function (Container $container): RoleRepository {
    $rawData = file_get_contents(__DIR__ . '/../data/roles.json');

    $dataSource = new DataSource(json_decode($rawData, true));
    return new RoleRepository($dataSource, new RoleBuilder());
};

return $container;