<?php

namespace Core\Helpers;

use Core\Exceptions\InvalidApplicationConfig;

class Config
{
    /**
     * @var string $path
     */
    private string $path = APP_PATH . '/config';

    /**
     * @return string
     */
    private function getPath() :string
    {
        return $this->path;
    }

    /**
     * @param string $file_name
     * @param string $ext
     * @return string
     */
    private function getFilePath(string $file_name, string $ext = 'php') :string
    {
        return $this->getPath() . DIRECTORY_SEPARATOR . $file_name . '.' . $ext;
    }

    /**
     * @param string $file_name
     * @param string $ext
     * @return mixed
     * @throws InvalidApplicationConfig
     */
    public function getItems(string $file_name = 'app', string $ext = 'php')
    {
        if (file_exists($this->getFilePath($file_name, $ext))) {
            return require($this->getFilePath($file_name, $ext));
        }

        throw new InvalidApplicationConfig(sprintf('Config file %s does not exist', $file_name));
    }
}