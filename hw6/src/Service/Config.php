<?php

declare(strict_types=1);

namespace Veraadzhieva\Hw6\Service;

use Exception;

class Config
{
    public $config_file;


    /*
     * Configs.
     *
     * @param string $config_file
     *
     * @throw Exception
     */
    public function __construct(string $config_file)
    {
        $this->config_file = $config_file;
        if (!is_file($this->config_file)) {
            throw new Exception('Конфигурационный файл не существует '.$this->config_file);
        }
    }

    /*
     * Получение конфигов для клиента и сервера.
     *
     * @param string $config_file
     *
     * @return $configs
     * @throw Exception
     */
    public function getConfigs(): array
    {
        $ini_array = parse_ini_file($this->config_file, true);

        if ($ini_array === false) {
            throw new Exception('Ошибка при обработки '.$this->config_file);
        } else {
            return $ini_array;
        }
    }
}