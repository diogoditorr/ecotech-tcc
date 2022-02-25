<?php declare(strict_types=1);

namespace App\Database;

use Dotenv\Dotenv;
use App\Php\Util;

class Connection
{
    private static \mysqli|null $instance = null;

    private function __construct(string $mode)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
        $dotenv->load();
        $dotenv->required(
            Util::getRequiredEnvironmentVariables()
        );

        self::$instance = new \mysqli(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            self::getDatabaseName($mode),
            (int) $_ENV['DB_PORT']
        );

        if (self::$instance->connect_error) {
            die("Connection failed: " . self::$instance->connect_error);
        }
    }

    private static function getDatabaseName(string $mode)
    {
        switch ($mode) {
            case 'production':
                $databaseName = $_ENV['DB_NAME'];
                break;
            case 'development':
                $databaseName = 'development_' . $_ENV['DB_NAME'];
                break;
            case 'testing':
                $databaseName = 'testing_' . $_ENV['DB_NAME'];
                break;
            default:
                throw new \Exception('Invalid mode');
        }

        return $databaseName;
    }

    public static function getInstance(string $mode = "production"): \mysqli
    {
        if (self::$instance === null) {
            new Connection($mode);
        }

        return self::$instance;
    }
}
