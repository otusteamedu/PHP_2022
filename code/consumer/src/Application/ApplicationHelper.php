<?php
declare(strict_types = 1);

namespace Ppro\Hw27\Consumer\Application;

use Ppro\Hw27\Consumer\Application\Conf;
use Ppro\Hw27\Consumer\Exceptions\AppException;

class ApplicationHelper
{
    private $config = __DIR__ . "/../Config/options.ini";
    private $reg;

    public function __construct()
    {
        $this->reg = Registry::instance();
    }

    public function init()
    {
        $this->setupOptions();

        $request = Request::getInstance();
        $this->reg->setRequest($request);
    }

    /** Формирование конфигурационных файлов приложения
     * @return void
     * @throws AppException
     */
    private function setupOptions()
    {
        if (! file_exists($this->config)) {
            throw new AppException("Could not find options file");
        }

        $options = parse_ini_file($this->config, true);
        $conf = new Conf($options['config']);
        $this->reg->setConf($conf);

        $envVars = $this->getEnvironmentVariables();

        $conf = new Conf($envVars);
        $this->reg->setEnvironment($conf);
    }

    /** Получаем необходимые для работы приложения переменные окружения
     * @return array
     */
    private function getEnvironmentVariables(): array
    {
        $env = getenv();
        return [
            'RABBITMQ_USER' => $env['RABBITMQ_USER'] ?? 'guest',
            'RABBITMQ_PASSWORD' => $env['RABBITMQ_PASSWORD'] ?? 'guest',
        ];
    }

}
