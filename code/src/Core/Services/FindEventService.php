<?php


namespace Decole\Hw13\Core\Services;


use Decole\Hw13\Core\Dtos\EventFindDto;

class FindEventService
{
    public function find(EventFindDto $dto): array
    {
        $result = (new StorageService())->find($dto);

        if (empty($result)) {
            return [];
        }

        $key = array_key_last($result);

        $events = [];

        foreach ($result[$key] as $event) {
            $events[] = $event->getName();
        }

        return $events;
    }

    public function createDto(array $query): EventFindDto
    {
        $dto = new EventFindDto();
        $dto->params = $query['params'];

        return $dto;
    }
}