<?php

declare(strict_types=1);

use App\Database\Connection;
use App\Php\Util;
use Dotenv\Dotenv;

putenv('APP_ENV=testing');
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();
$dotenv->required(
    Util::getRequiredEnvironmentVariables()
);

$connection = Connection::getInstance();
