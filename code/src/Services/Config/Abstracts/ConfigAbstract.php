<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Config\Abstracts;

use Nsavelev\Hw6\Services\Config\Interfaces\ConfigInterface;

abstract class ConfigAbstract implements ConfigInterface
{
    /** @var ConfigInterface|null */
    private static ?ConfigInterface $instance = null;

    /** @var string */
    protected string $pathToConfigDirectory;

    private function __construct()
    {
        $this->pathToConfigDirectory = $this->getPathToConfigDirectory();
    }

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        $config = static::$instance;

        if (empty($config)) {
            $config = new static();
        }

        return $config;
    }

    /**
     * @param string $pathToValue
     * @return array|bool|string|float|int
     */
    public function get(string $pathToValue): array|bool|string|float|int
    {
        $valuePath = $this->getPartsOfPathToValue($pathToValue);

        $pathToConfigFile = $this->getPathToConfigFile($valuePath);

        $value = $this->getValueFromConfigFile($pathToConfigFile, $valuePath);

        return $value;
    }

    /**
     * @param string $pathToValue
     * @return array
     */
    abstract protected function getPartsOfPathToValue(string $pathToValue): array;

    /**
     * @param array $valuePath
     * @return string
     */
    abstract protected function getPathToConfigFile(array &$valuePath): string;

    /**
     * @param string $pathToConfigFile
     * @param array $valuePath
     * @return array|bool|string|float|int
     */
    abstract protected function getValueFromConfigFile(string $pathToConfigFile, array $valuePath): array|bool|string|float|int;

    /**
     * @return string
     */
    abstract protected function getPathToConfigDirectory(): string;
}