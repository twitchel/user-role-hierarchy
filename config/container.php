<?php
declare(strict_types=1);

use Pimple\Container;
use Symfony\Component\Console\Application;
use UserRoleHierarchy\Command\GetUserCommand;
use UserRoleHierarchy\Data\DataSource;
use UserRoleHierarchy\Entity\Builder\UserBuilder;
use UserRoleHierarchy\Repository\UserRepository;

$container = new Container();

$container[Application::class] = static function (Container $container): Application {
    $application = new Application('User Role Hierarchy');

    $application->add(new GetUserCommand($container[UserRepository::class]));

    return $application;
};

$container[UserRepository::class] = static function (Container $container): UserRepository {
    $rawData = file_get_contents(__DIR__ . '/../data/users.json');

    $dataSource = new DataSource(json_decode($rawData, true));
    return new UserRepository($dataSource, new UserBuilder());
};

return $container;