<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Config\Configs\Extensions\Php;

use Nsavelev\Hw6\Services\Config\Abstracts\ConfigAbstract;
use Nsavelev\Hw6\Services\Config\Exceptions\FileWithConfigWasNotFoundException;
use Nsavelev\Hw6\Services\Config\Exceptions\PathToConfigFileDoesntExistException;
use Nsavelev\Hw6\Services\Config\Exceptions\ValueDoesntExistException;

class Config extends ConfigAbstract
{
    /** @var string */
    protected const FILE_EXTENSION = '.php';

    /**
     * @param string $pathToValue
     * @return array
     */
    protected function getPartsOfPathToValue(string $pathToValue): array
    {
        $partsOfPath = explode('.', $pathToValue);

        return $partsOfPath;
    }

    /**
     * @param array $valuePath
     * @return string
     * @throws FileWithConfigWasNotFoundException
     * @throws PathToConfigFileDoesntExistException
     */
    protected function getPathToConfigFile(array &$valuePath): string
    {
        $pathToFile = $this->pathToConfigDirectory;

        $isFileFound = false;

        foreach ($valuePath as $key => $pathPart) {

            if (is_dir($pathToFile . $pathPart)) {
                $pathToFile .= "$pathPart/";
            }

            $partPathWithExtension = $pathPart . self::FILE_EXTENSION;

            if (is_file($pathToFile . $partPathWithExtension)) {
                $pathToFile .= $partPathWithExtension;
                $isFileFound = true;
            }

            unset($valuePath[$key]);

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

    /**
     * @param string $pathToConfigFile
     * @param array $valuePath
     * @return string
     * @throws ValueDoesntExistException
     */
    protected function getValueFromConfigFile(string $pathToConfigFile, array $valuePath): array|bool|string|float|int
    {
        $configValues = include ($pathToConfigFile);

        foreach ($valuePath as $pathPart) {
            if (!is_array($configValues) || !array_key_exists($pathPart, $configValues)) {
                throw new ValueDoesntExistException('Value doesnt exist in config file.');
            }

            $configValues = $configValues[$pathPart];
        }

        $value = $configValues;

        return $value;
    }

    /**
     * @return string
     */
    protected function getPathToConfigDirectory(): string
    {
        $pathToConfigFiles = $_SERVER['PWD'] . '/src/Config/';

        return $pathToConfigFiles;
    }
}