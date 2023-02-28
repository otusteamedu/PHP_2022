<?php

declare(strict_types=1);

namespace Igor\Hw4\HTTP;

/**
 * Класс Request
 */
class Request
{
    /**
     * Получить путь запроса без строки запроса и имени выполняемого
     * скрипта
     * 
     * @return string
     */
    public function getPathInfo()
    {
        // извлекаем из URI путь запроса,
        $path_info = str_replace(
            '?' . $_SERVER['QUERY_STRING'],
            '',
            $_SERVER['REQUEST_URI']
        );
        $path_info = str_replace(
            $_SERVER['SCRIPT_NAME'],
            '',
            $path_info
        );
        $path_info = trim($path_info, '/');

        // возвращаем результат
        return empty($path_info) ? '/' : $path_info;
    }

    /**
     * Поиск и получение значения параметра зпроса
     * по ключу
     * 
     * @param string $key               искомый ключ параметра запроса
     * @return mixed                    значение параметра 
     *                                  или null если параметр не существует
     */
    public function find($key)
    {
        if (key_exists($key, $_REQUEST))
            return $_REQUEST[$key];
        else
            return null;
    }

    /**
     * Проверяет существование параметра в запросе
     * по его ключу
     * 
     * @param string $key               проверяемый ключ
     * @return boolean
     */
    public function has($key)
    {
        return key_exists($key, $_REQUEST);
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}