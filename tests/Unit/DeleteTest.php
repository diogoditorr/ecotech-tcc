<?php declare(strict_types=1);

use App\Database\Connection;
use PHPUnit\Framework\TestCase;

final class DeleteTest extends TestCase
{
    private static mysqli $connection;

    public static function setUpBeforeClass(): void
    {
        self::$connection = Connection::getInstance();
    }

    public function testDeleteAllTablesData(): void
    {
        $this->assertTrue(self::$connection->query('DELETE FROM `person`'));
        $this->assertTrue(self::$connection->query('DELETE FROM `address`'));
        $this->assertTrue(self::$connection->query('DELETE FROM `profile`'));
        $this->assertTrue(self::$connection->query('DELETE FROM `eletronic_part`'));
        $this->assertTrue(self::$connection->query('DELETE FROM `interested`'));
        $this->assertTrue(self::$connection->query('DELETE FROM `order`'));
    }
}