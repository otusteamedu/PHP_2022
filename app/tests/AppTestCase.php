<?php

namespace Otus\Tests;

use PDO;
use Otus\Core\Config\Env;
use PHPUnit\Framework\TestCase;
use Otus\Core\Database\DBConnection;

class AppTestCase extends TestCase
{
    protected PDO $pdo;

    private static $dump = null;

    public static function setUpBeforeClass(): void
    {
        self::initEnv();
        self::initDB();
        if (empty(self::$dump)) {
            self::$dump = file_get_contents(__DIR__ . '/../dump.sql');
        }
    }

    protected function setUp(): void
    {
        $this->pdo = DBConnection::connect();
        $this->pdo->exec("DROP TABLE IF EXISTS comments");
        $this->pdo->exec("DROP TABLE IF EXISTS posts");
        $this->pdo->exec(self::$dump);
    }

    private static function initEnv(): void
    {
        Env::loadFromEnv(__DIR__ . '/../.env');
    }

    private static function initDB(): void
    {
        $dsn = sprintf(
            '%s:dbname=%s;host=%s',
            Env::get('DB_CONNECTION'),
            Env::get('DB_NAME'),
            Env::get('DB_TEST_HOST'),
        );
        $user = Env::get('DB_USER');
        $password = Env::get('DB_PASSWORD');
        DBConnection::setOptions($dsn, $user, $password);
    }
}