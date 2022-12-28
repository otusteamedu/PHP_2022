<?php

namespace Ppro\Hw13;

/** класс для работы с реестром параметров приложения
 *
 */
class Register
{
    private static $instance = null;
    private Request $request;
    private Conf $config;
    private array $context = [];
    private function __construct()
    {
    }

    public static function instance(): self
    {
        if(is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public static function reset(): void
    {
        self::$instance = null;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Conf $config
     */
    public function setConfig(Conf $config): void
    {
        $this->config = $config;
    }

    /**
     * @return Conf
     */
    public function getConfig(): Conf
    {
        return $this->config;
    }

    public function setValue(string $key, $value): void
    {
        $this->context[$key] = $value;
    }

    public function setValueMulti(array $params = []): void
    {
        array_walk($params,fn($val,$key) => $this->context[$key] = $val);
    }

    public function getValue(string $key, mixed $defaultValue = "")
    {
        return $this->context[$key] ?? $defaultValue;
    }

    public function getContext(): array
    {
        return $this->context;
    }

}