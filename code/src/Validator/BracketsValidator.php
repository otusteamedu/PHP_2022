<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\Validator;

class BracketsValidator
{
    /**
     * Строка со скобками
     *
     * @var mixed|null
     */
    private $brackets;

    /**
     * Ошибки при валидации
     *
     * @var string|null
     */
    private ?string $error = null;

    /**
     * Статусы валидации
     */
    private const STATUS_ERROR = 'danger';
    private const STATUS_SUCCESS = 'success';

    /**
     * Тексты ошибок
     */
    private const ERROR_EMPTY = 'Не введены данные';
    private const ERROR_INVALID_CHARACTER = 'Должны быть введены только скобочки';
    private const ERROR_INVALID_BRACKETS = 'Строка со скобками не валидна';

    /**
     * Constructor
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->brackets = $request['string'] ?? null;
    }

    /**
     * Валидация
     *
     * @return bool
     */
    public function validate(): bool
    {
        if (empty($this->brackets)) {
            $this->error = self::ERROR_EMPTY;
        } elseif (!empty(preg_replace('/[\(\)]+/', '', $this->brackets))) {
            $this->error = self::ERROR_INVALID_CHARACTER;
        } elseif (!$this->validBrackets()) {
            $this->error = self::ERROR_INVALID_BRACKETS;
        }

        return empty($this->error);
    }

    /**
     * Получить статус валидации
     *
     * @return string
     */
    public function getStatus(): string
    {
        return empty($this->error) ? self::STATUS_SUCCESS : self::STATUS_ERROR;
    }

    /**
     * Получить текстовую расшифровку статуса
     *
     * @return string
     */
    public function getTextStatus(): string
    {
        return empty($this->error) ? 'Валидация прошла успешно' : 'Ошибка! ' . $this->error;
    }

    /**
     * Валидация строки со скобочками
     *
     * @return bool
     */
    private function validBrackets(): bool
    {
        $arBrackets = str_split($this->brackets);
        return !($arBrackets[0] !== '(' || $arBrackets[count($arBrackets) - 1] !== ')' || !$this->calcBrackets($arBrackets));
    }

    /**
     * Подсчет открывающихся и закрывающихся скобочек
     *
     * @param array $arBrackets
     * @return bool
     */
    private function calcBrackets(array $arBrackets): bool
    {
        $count = 0;
        foreach ($arBrackets as $bracket) {
            if ($bracket === '(') {
                $count++;
            } elseif ($bracket === ')') {
                $count--;
            }
        }
        return $count === 0;
    }
}