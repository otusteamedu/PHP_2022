<?php

declare(strict_types=1);

namespace Ekaterina\Hw5\Validators;

use SplFileInfo;

class FileValidator
{
    /**
     * Тексты ошибок при валидации файлов
     */
    private const ERROR_NO_FILE = 'Это не файл или такого файла не существует';
    private const ERROR_EXTENSION = 'Данный тип файла не поддерживается';
    private const ERROR_READ = 'Файл недоступен для чтения';
    private const ERROR_SIZE = 'Файл пустой';

    /**
     * Разрешенные расширения файлов
     */
    private const EXTENSIONS = ['txt', 'log', 'err', 'text'];

    /**
     * @var SplFileInfo Файл
     */
    private SplFileInfo $file;

    /**
     * @var string|null Текст ошибки при валидации файла
     */
    private ?string $error = null;

    /**
     * @var bool Определение успешности валидации
     */
    private bool $result = false;

    /**
     * Constructor
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = new SplFileInfo($file);
        $this->validate();
    }

    /**
     * Валидация файла
     *
     * @return void
     */
    private function validate(): void
    {
        if (!$this->file->isFile()) {
            $this->error = self::ERROR_NO_FILE;
        } elseif (!in_array($this->file->getExtension(), self::EXTENSIONS)) {
            $this->error = self::ERROR_EXTENSION;
        } elseif(!$this->file->isReadable()) {
            $this->error = self::ERROR_READ;
        } elseif(!$this->file->getSize()) {
            $this->error = self::ERROR_SIZE;
        }

        $this->result = empty($this->error);
    }

    /**
     * Возвращает текст ошибки
     *
     * @return string
     */
    public function getError(): string
    {
        return $this->error ?? '';
    }

    /**
     * Результат валидации
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->result;
    }
}