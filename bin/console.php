<?php
declare(strict_types=1);

use Symfony\Component\Console\Input\ArgvInput;

require_once __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/container.php';

$application = $container['application'];

$application->run(new ArgvInput());
