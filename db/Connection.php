<?php declare(strict_types=1);

namespace App\Database;

use Dotenv\Dotenv;
use App\Php\Util;

class Connection
{
    public static function connect(): \mysqli
    {
        $dotenv = Dotenv::createImmutable((__DIR__ . "/../"));
        $dotenv->load();
        $dotenv->required(Util::getRequiredVariablesEnvironment());

        $conn = new \mysqli(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            $_ENV['DB_NAME'],
            (int) $_ENV['DB_PORT']
        );

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}
