<?php

namespace Ppro\Hw13\Data;

/** DTO для полного описания событий(параметры, приоритет, условия)
 *
 */
final class EventDTO
{
    private string $name;
    private int $priority;
    private array $params;

    public function __construct(string $name = '', int $priority = 0, string $params = '')
    {
        $this->name = $name;
        $this->priority = $priority;
        $paramsDTO = new ParamsDTO($params);
        $this->params = $paramsDTO->getParams();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getParams()
    {
        return $this->params;
    }
}