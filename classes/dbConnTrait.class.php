<?php

trait dbConnTrait
{
    private \Pixie\QueryBuilder\QueryBuilderHandler $pqb;

    /**
     * Read .ini config file
     * @param string $botName
     * @return void
     * @throws Exception
     */
    public function readConfig(string $botName): void
    {
        if(!$botName) {
            throw new \Exception("Botname is not set in QueryBuilder.");
        }

        $filename = __DIR__ . '/../config/' . $botName . ".ini";
        $config = parse_ini_file($filename, true);

        if($config === false) {
            throw new \Exception("Config file not found.");
        }

        $this->config = $config['db'];
    }

    /**
     * @return void
     */
    public function connectDB()
    {
        // Alias gives you the ability to easily access the QueryBuilder class across your application using PQB::
        if(!class_exists('PQB')) {
            new \Pixie\Connection('mysql', $this->config, 'PQB');
        }

        $connection = new \Pixie\Connection('mysql', $this->config);
        $this->pqb = new \Pixie\QueryBuilder\QueryBuilderHandler($connection);
    }
}