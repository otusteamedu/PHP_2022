<?php

namespace Koptev\Hw6;

use Exception;

class Config
{
    private array $config = [];

    /**
     * @param string $name
     * @return void
     * @throws Exception
     */
    public function load(string $name)
    {
        $filename = 'config/' . $name . '.php';

        if (!file_exists($filename)) {
            throw new Exception('File ' . $filename . ' doesnt exist.');
        }

        $this->config[$name] = $this->loadFromFile($filename);
    }

    /**
     * @param string $filename
     * @return array
     */
    private function loadFromFile(string $filename): array
    {
        return include $filename;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if (strpos($name, '.')) {
            $names = explode('.', $name);
        } else {
            $names = [$name];
        }

        $key = array_shift($names);

        $config = $this->config[$key];

        foreach ($names as $n) {
            $config = $config[$n];
        }

        return $config;
    }
}
