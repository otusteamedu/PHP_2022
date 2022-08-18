<?php

require_once __DIR__ . '/vendor/autoload.php';

use Sbbs\PdoDb\Src\PdoDb;

class TestPdoDb {

    public PdoDb $db;

    public function __construct($db_config)
    {
        $this->db = PdoDb::getInstance($db_config);
    }

    public function testDbConnection(): PdoDb
    {
        echo __CLASS__ . __METHOD__;
        echo PHP_EOL;

        return $this->db;
    }

    public function testLog(): array
    {
        echo __CLASS__ . __METHOD__;
        echo PHP_EOL;

        return $this->db->getLog();
    }

    public function testInsert(string $name): int
    {
        $query = "INSERT INTO `test_table`(`name`, `date`) VALUES(:name, :date);";
        $parameters = [
            ':name' => $name . time(),
            ':date' => time(),
        ];

        echo __CLASS__ . __METHOD__;
        echo PHP_EOL;

        return $this->db->exec(
            $query,
            $parameters,
            __METHOD__,
        );
    }

    public function testUpdate(int $id, string $name): int
    {
        $query = "UPDATE `test_table` SET `name` = :name, `date` = :date WHERE `id` = :id;";
        $parameters = [
            ':name' => $name . time(),
            ':date' => time(),
            ':id' => $id,
        ];

        echo __CLASS__ . __METHOD__;
        echo PHP_EOL;

        return $this->db->exec(
            $query,
            $parameters,
            __METHOD__,
        );
    }

    public function testLastId(): int
    {
        echo __CLASS__ . __METHOD__;
        echo PHP_EOL;

        return $this->db->getLastId();
    }

    public function testFetchOne(int $id): array
    {
        $query = 'SELECT `name`, `date` FROM `test_table` WHERE `id` = :id;';
        $parameters = [
            ':id' => $id,
        ];

        echo __CLASS__ . __METHOD__;
        echo PHP_EOL;

        return $this->db->fetchOne(
            $query,
            $parameters,
            __METHOD__,
        );
    }

    public function testFetchAll(): array
    {
        $query = 'SELECT `name`, `date` FROM `test_table`;';
        $parameters = [];

        echo __CLASS__ . __METHOD__;
        echo PHP_EOL;

        return $this->db->fetchAll(
            $query,
            $parameters,
            __METHOD__,
        );
    }
}

$db_config = parse_ini_file('.env');
$test = new TestPdoDb($db_config);

print_r($test->testDbConnection());
echo PHP_EOL;

$data = [
    'name_',
    'name__'
];
foreach ($data as $name) {
    $test->testInsert($name);
    echo PHP_EOL;
}

$lastId = $test->testLastId();
print_r($lastId);
echo PHP_EOL;

print_r($test->testUpdate($lastId, 'new_name_'));
echo PHP_EOL;

print_r($test->testFetchOne($lastId));
echo PHP_EOL;

print_r($test->testFetchAll());
echo PHP_EOL;

print_r($test->testLog());
