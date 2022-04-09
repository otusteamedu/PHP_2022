<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\ServerData;

class ServerData
{
    /**
     * @var string|false|null Текущая дата
     */
    protected ?string $date = null;

    /**
     * @var string|null ID сессии
     */
    private ?string $sessionId;

    /**
     * @var string|null Имя хоста
     */
    private ?string $hostName;

    /**
     * Constructor
     */
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->date = date('d.m.Y H:i:s') ?: null;
        $this->sessionId = session_id() ?: null;
        $this->hostName = self::getServerInfo('HOSTNAME');
    }

    /**
     * Получить дату
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date ?? 'нет данных';
    }

    /**
     * Получить ID сессии
     *
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId ?? 'нет данных';
    }

    /**
     * Получить имя хоста
     *
     * @return string
     */
    public function getHostName(): string
    {
        return $this->hostName ?? 'нет данных';
    }

    /**
     * Получение значения  $name из $_SERVER
     *
     * @param string $name
     * @return mixed|null
     */
    public static function getServerInfo(string $name)
    {
        return $_SERVER[$name] ?: null;
    }

    /**
     * Получение всех данных о сервере в виде массива
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'date' => $this->getDate(),
            'sessionId' => $this->getSessionId(),
            'hostName' => $this->getHostName(),
        ];
    }
}