<?php
declare(strict_types=1);

use Pimple\Container;
use Symfony\Component\Console\Application;

$container = new Container();

$container['application'] = static function (Container $container) {
    return new Application('User Role Hierarchy');
};

return $container;