<?php

declare(strict_types=1);

namespace App\SearchEngine;

use App\SearchEngine\Validation\Validator;
use App\SearchEngine\Mechanisms\{CliDialog, Connection, QueryBuilder};
use Elastic\Elasticsearch\Exception\{AuthenticationException, ClientResponseException, ServerResponseException};
use function cli\line;

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
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * Кто подставил поручика Ржевского на Луне,Советы по выращиванию рептилоидов под мухой
     * Исторический роман,Детектив
     * Мира,Ленина
     * 500-000
     */
    public static function start(): void
    {
        $connection = new Connection();
        $cli_dialog = new CliDialog();

        $query_params_from_user = $cli_dialog->startDialog();

        $validator = new Validator(query_params_dto: $query_params_from_user);

        if (! $validator->validate()) {
            line(
                msg: 'Ошибка валидации' . PHP_EOL
            );

            return;
        }

        $query_builder = new QueryBuilder(query_params_dto: $query_params_from_user);

        $response = $connection
            ->connect()
            ->search($query_builder->buildQuery())->asArray();

        var_dump($query_params_from_user, $response['hits']['hits']);
    }
}
