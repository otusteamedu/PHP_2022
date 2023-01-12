<?php

namespace Otus\App\Application\Entity;

use Otus\App\App;
use Otus\App\Application\Viewer\View;
use PDO;

abstract class ActiveRecordEntity
{
    private static $connectionInstance;

    private static function getInstance()
    {
        try {
            $config = App::getConfigBD();

            if(self::$connectionInstance === null) {
                self::$connectionInstance = new PDO(sprintf("%s:host=%s;dbname=%s",
                    $config['conf_bd']['type'],
                    $config['conf_bd']['host'],
                    $config['conf_bd']['db']),
                    $config['conf_bd']['user'],
                    $config['conf_bd']['password'],
                    [
                        // При возврате результатов запроса - возвращать в виде ассоциативного массива
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
                    ]);
            }
            return self::$connectionInstance;
        } catch (\Exception $e) {
            View::render('error', [
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
            ]);
        }
    }

    public function Model()
    {
        self::getInstance();
    }

    protected static $table;

    private static function getTableName()
    {
        return static::$table;
    }

    public static function get($parameter, $value)
    {
        $modelName = static::class;
        $model = new $modelName();
        $tableName = self::getTableName();
        $sql = "SELECT * FROM $tableName where $parameter = ?";
        $statement = self::getInstance()->prepare($sql);
        $statement->execute([$value]);
        $result = $statement->fetchAll();
        if($statement->rowCount() === 0)
            return $result;
        return $result;
    }

    public static function findAll(): array
    {
        $modelName = static::class;
        $model = new $modelName();
        $tableName = self::getTableName();
        $sql = "SELECT * FROM $tableName";
        $statement = self::getInstance()->prepare($sql);
        $statement->execute([]);
        $result = $statement->fetchAll();
        if($statement->rowCount() === 0)
            return $result;
        return $result;
    }

    private $isInserted = false;

    public function save()
    {
        $parameters = get_object_vars($this);
        unset($parameters['isInserted']);
        $tableName = self::getTableName();

        if($this->isInserted) {
            $params = array_keys($parameters);
            $values = array_values($parameters);
            $values[] = array_shift($values);
            $update = "";
            unset($params[0]);
            foreach ($params as $key) {
                $update .= "$key = ?,";
            }
            $update = substr($update,0,-1);
            $query = "update $tableName set $update where id = ?";
            $statement = self::getInstance()->prepare($query);
            $statement->execute($values);
        } else {
            $params = array_keys($parameters);
            $temple = substr(str_repeat('?,',sizeof($params)),0,-1);
            $columns = implode(',',$params);
            $values = array_values($parameters);
            $query = "insert into $tableName ($columns) values ($temple)";
            $statement = self::getInstance()->prepare($query);
            $statement->execute($values);
            $this->id = self::getInstance()->lastInsertId();
            return $this->id;
        }
    }

    public function delete()
    {
        $modelName = static::class;
        $model = new $modelName();
        $tableName = self::getTableName();
        $sql = "DELETE FROM $tableName where id = ?";
        $statement = self::getInstance()->prepare($sql);
        $statement->execute([$this->id]);
    }
}
