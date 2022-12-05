<?php

namespace Ppro\Hw7\Helper;

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

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
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