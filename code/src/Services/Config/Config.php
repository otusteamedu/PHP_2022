<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Config;

use Nsavelev\Hw6\Services\Config\Exceptions\FileWithConfigWasNotFoundException;
use Nsavelev\Hw6\Services\Config\Exceptions\PathToConfigFileDoesntExistException;
use Nsavelev\Hw6\Services\Config\Exceptions\ValueDoesntExistException;

class Config
{
    /** @var Config|null */
    private static ?Config $instance = null;

    /** @var string  */
    private string $pathToConfigDirectory;

    /** @var string */
    private const FILE_EXTENSION = '.php';

    private function __construct()
    {
        $this->pathToConfigDirectory = $_SERVER['PWD'] . '/src/Config/';
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        $config = self::$instance;

        if (empty($config)) {
            $config = new self();
        }

        return $config;
    }

    /**
     * @param string $pathToValue
     * @format 'path.to.file.and.value'
     *
     * @return array|bool|int|string
     * @throws FileWithConfigWasNotFoundException
     * @throws PathToConfigFileDoesntExistException
     * @throws ValueDoesntExistException
     */
    public function get(string $pathToValue): array|bool|int|string
    {
        $pathToValueParts = explode('.', $pathToValue);

        $pathToConfigFile = $this->getPathToFile($pathToValueParts);

        $value = $this->getValueFromConfigFile($pathToConfigFile, $pathToValueParts);

        return $value;
    }

    /**
     * @param string $pathToConfigFile
     * @param array $pathToValue
     * @return bool|null|string|array|int
     * @throws ValueDoesntExistException
     */
    private function getValueFromConfigFile(string $pathToConfigFile, array $pathToValue): bool|null|string|array|int
    {
        $configValues = include ($pathToConfigFile);

        foreach ($pathToValue as $pathPart) {
            if (!is_array($configValues) || !array_key_exists($pathPart, $configValues)) {
                throw new ValueDoesntExistException('Value doesnt exist in config file.');
            }

            $configValues = $configValues[$pathPart];
        }

        $value = $configValues;

        return $value;
    }

    /**
     * @param array<string> $pathToValueParts
     * @return string
     * @throws FileWithConfigWasNotFoundException|PathToConfigFileDoesntExistException
     */
    private function getPathToFile(array &$pathToValueParts): string
    {
        $pathToFile = $this->pathToConfigDirectory;

        $isFileFound = false;

        foreach ($pathToValueParts as $key => $pathPart) {

            if (is_dir($pathToFile . $pathPart)) {
                $pathToFile .= "$pathPart/";
            }

            $partPathWithExtension = $pathPart . self::FILE_EXTENSION;

            if (is_file($pathToFile . $partPathWithExtension)) {
                $pathToFile .= $partPathWithExtension;
                $isFileFound = true;
            }

            unset($pathToValueParts[$key]);

            if ($isFileFound) {
                break;
            }
        }

        if (!$isFileFound) {
            throw new FileWithConfigWasNotFoundException('Config file was not found.');
        }

        $isPathToFileExist = realpath($pathToFile);

        if (!($isPathToFileExist)) {
            throw new PathToConfigFileDoesntExistException('Path to config file doesnt exists.');
        }

        return $pathToFile;
    }

}