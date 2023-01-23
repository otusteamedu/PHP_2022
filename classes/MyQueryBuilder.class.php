<?php

// Make sure you have Composer's autoload file included
require 'vendor/autoload.php';

require_once('dbConnTrait.class.php');

/**
 * Usage of Pixie SQL QueryBuilder
 * @see https://github.com/usmanhalalit/pixie
 */

class MyQueryBuilder
{
    private array $config;

    use dbConnTrait;

    /**
     * @param string $botName
     * @throws Exception
     */
    public function __construct(string $botName = '')
    {
        $this->readConfig($botName);
        $this->connectDB();
    }

    /**
     * @param array $data
     * @return int
     */
    public function insertData(string $table, array $data): int
    {
        $insertId = $this->pqb->table($table)->insert($data);

        return $insertId;
    }

    /**
     * Delete table's data
     * @param string $table
     * @param array $data
     * @return int
     */
    public function deleteData(string $table, array $whereArr): bool
    {
        $query = $this->pqb->table($table);

        foreach($whereArr as $where) {
            $query->where($where[0], $where[1], $where[2]);
        }

        $query->delete();

        return true;
    }

    /**
     * Fetch data from table
     * @param string $table
     * @param array $where
     * @return stdClass
     */
    public function getData(string $table, array $columns, array $whereArr): array
    {
        $query = $this->pqb->table($table);
        foreach($columns as $col) {
            $query->select($col);
        }

        foreach($whereArr as $where) {
            $query->where($where[0], $where[1], $where[2]);
        }

        return $query->get();
    }

    /**
     * Update data
     */
    public function updateData(string $table, array $columns, array $whereArr): bool
    {
        $query = $this->pqb->table($table);
        foreach($columns as $col) {
            $query->select($col);
        }

        foreach($whereArr as $where) {
            $query->where($where[0], $where[1], $where[2]);
        }

        $query->update($columns);

        return true;
    }

    /**
     * Fetch info
     * @param string $section
     * @return string
     */
    public function getInfo(string $section): string
    {
        $data = $this->getData('info', ['text'], [['section', '=', $section]]);

        return $data[0]->text ?: '';
    }
}