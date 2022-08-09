<h1>application.local index.php</h1>

<?php
$key = 'Bilbo';
$value = 'Ring';

echo '<br>php -> Memcached basic check: <br>';
$memcached = new Memcached();
if ($memcached->addServer('memcached', 11211)) {
    check_store_basic($memcached, $key, $value);
} else {
    echo 'Failed';
}

echo '<br><br>php -> Redis basic check: <br>';
$redis = new Redis();
$redis->connect('redis', 6379);
if ($redis->connect('redis', 6379)) {
    check_store_basic($redis, $key, $value);
} else {
    echo 'Failed';
}

echo '<br><br>php -> postgres connect check: <br>';
$host = 'database';
$db = 'postgres';
$user = 'postgres';
$port = 5432;
$password = 'test_pass';
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    if ($pdo) {
        echo "Connected to the database \"$db\" successfully!";
        echo '<br>Some information_schema tables: <br>';
        $sql = 'SELECT * FROM information_schema.tables';
        $result = $pdo->query($sql)->fetchAll();
        $index = 0;
        foreach ($result as $row) {
            if ($row['table_schema'] === 'information_schema') {
                echo 'table_name: ', $row['table_name'], '; ';
                echo 'table_type: ', $row['table_type'], '<br>';
                $index++;
            }
            if ($index > 10) {
                break;
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
} finally {
    if ($pdo) {
        $pdo = null;
    }
}

phpinfo();

function check_store_basic($source, string $key = '', string $value = ''): void {
    $get_response = $source->get($key);
    if ($get_response) {
        echo $key, ' has ', $get_response;
    } else {
        echo "Adding value $value for key $key :<br>";
        $set_response = $source->set('Bilbo', $value);
        if (!$set_response) {
            echo 'Failed';
        } else {
            echo $value, ' was added for ', $key, '. Refresh for check.';
        }
    }
}
