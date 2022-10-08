<?php

declare(strict_types=1);

namespace App\SearchEngine;

use function cli\line;
use App\SearchEngine\Validation\Validator;
use App\SearchEngine\Mechanisms\{CliDialog, Connection, QueryBuilder, Render};

final class Engine
{
    /**
     * @var array
     */
    private static array $instances = [];

    /**
     * construct
     */
    protected function __construct() {}

    /**
     * @return void
     */
    protected function __clone() {}

    /**
     * @return mixed
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception(message: "Cannot unserialize a singleton.");
    }

    /**
     * @return Engine
     */
    public static function getInstance(): Engine
    {
        $cls = Engine::class;

        if (! isset(self::$instances[$cls])) {
            self::$instances[$cls] = new Engine();
        }

        return self::$instances[$cls];
    }

    /**
     * @return void
     */
    public static function start(): void
    {
        $cli_dialog = new CliDialog();
        $query_params_from_user = $cli_dialog->startDialog();

        $validator = new Validator(query_params_dto: $query_params_from_user);

        if (! $validator->validate()) {
            line(msg: 'Ошибка валидации' . PHP_EOL);

            return;
        }

        $query_builder = new QueryBuilder(query_params_dto: $query_params_from_user);
        $connection = new Connection();

        try {
            $response = $connection
                ->connect()
                ->search($query_builder->buildQuery())->asArray();

            $render = new Render(search_results: $response);

            $render->redner();
        } catch (\Throwable $exception) {
            line(msg: 'Ошибка: ' . $exception->getMessage() . PHP_EOL);
        }
    }
}
