<?php
declare(strict_types=1);

use Pimple\Container;
use Symfony\Component\Console\Application;
use UserRoleHierarchy\Command\GetUserCommand;
use UserRoleHierarchy\Data\Builder\UserDataBuilder;
use UserRoleHierarchy\Entity\Builder\UserBuilder;
use UserRoleHierarchy\Repository\UserRepository;

$container = new Container();

$container[Application::class] = static function (Container $container): Application {
    $application = new Application('User Role Hierarchy');

    $application->add(new GetUserCommand($container[UserRepository::class]));

    return $application;
};

$container[UserDataBuilder::class] = static function (Container $container): UserDataBuilder {
    return new UserDataBuilder(new UserBuilder());
};

$container[UserRepository::class] = static function (Container $container): UserRepository {
    $rawUserData = file_get_contents(__DIR__ . '/../data/users.json');

    $userData = $container[UserDataBuilder::class]->build(json_decode($rawUserData, true));
    return new UserRepository($userData);
};

return $container;