<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\Validator;

class BracketsValidator
{
    /**
     * Тексты ошибок
     */
    private const ERROR_EMPTY = 'Не введены данные';
    private const ERROR_INVALID_CHARACTER = 'Должны быть введены только скобочки';
    private const ERROR_INVALID_BRACKETS = 'Строка со скобками не валидна';
    private const ERROR_NONE_VALIDATE = 'Валидация не проводилась';

    /**
     * Текст успешной валидации
     */
    private const SUCCESS_VALIDATE = 'Валидация прошла успешно';

    /**
     * @var mixed|null Строка со скобками
     */
    private $brackets;

    /**
     * @var string|null Ошибки при валидации
     */
    private ?string $error = null;

    /**
     * @var bool Определение проводилась ли валидация
     */
    private bool $isChecked;

    /**
     * Constructor
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->brackets = $request['string'] ?? null;
        $this->isChecked = false;
    }

    /**
     * Валидация
     *
     * @return void
     */
    public function validate(): void
    {
        $this->isChecked = true;

        if (empty($this->brackets)) {
            $this->error = self::ERROR_EMPTY;
        } elseif (!empty(preg_replace('/[\(\)]+/', '', $this->brackets))) {
            $this->error = self::ERROR_INVALID_CHARACTER;
        } elseif (!$this->validBrackets()) {
            $this->error = self::ERROR_INVALID_BRACKETS;
        }
    }

    /**
     * Валидация строки со скобочками
     *
     * @return bool
     */
    private function validBrackets(): bool
    {
        if ($this->brackets[0] !== '(' || $this->brackets[strlen($this->brackets) - 1] !== ')') {
            return false;
        }

        return $this->calcBrackets();
    }

    /**
     * Подсчет открывающихся и закрывающихся скобочек
     *
     * @return bool
     */
    private function calcBrackets(): bool
    {
        $count = 0;
        $strlen = strlen($this->brackets);

        for ($i = 0; $i < $strlen; $i++) {
            if ($this->brackets[$i] === '(') {
                $count++;
            } elseif ($this->brackets[$i] === ')') {
                $count--;
            }
        }

        return $count === 0;
    }

    /**
     * Получить результат валидации
     *
     * @return bool
     */
    public function getResultValidate(): bool
    {
        return $this->isChecked && empty($this->error);
    }

    /**
     * Получить текстовую расшифровку валидации
     *
     * @return string
     */
    public function getResultMessage(): string
    {
        if (!$this->isChecked) {
            return self::ERROR_NONE_VALIDATE;
        }

        return empty($this->error) ? self::SUCCESS_VALIDATE : 'Ошибка! ' . $this->error;
    }
}