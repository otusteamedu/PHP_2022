<?php

namespace Ppro\Hw13;

/** вспомогательный класс для работы с конфигурацией
 *
 */
class Conf
{
    private string $path;
    private array $config;

    /**
     * @param string $path
     * @throws \Exception
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        if(!file_exists($this->path))
            throw new \Exception("Configuration file not found");
        $this->createConfig();
    }

    public function createConfig(): void
    {
        $this->config = parse_ini_file($this->path, true) ?: [];
    }

    public function getSection(string $section, array $default = []): array
    {
        return $this->config[$section] ?? $default;
    }

    public function getValue(string $section, string $key, string $default = ""): string
    {
        return $this->getSection($section)[$key] ?? $default;
    }
}