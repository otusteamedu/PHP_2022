<?php

namespace App\Application\DTO;

use App\Domain\Contract\GetEventDTOInterface;

class GetEventDTO implements GetEventDTOInterface
{
    private array $params;


    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }


    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

}
