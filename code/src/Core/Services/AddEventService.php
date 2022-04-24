<?php


namespace Decole\Hw13\Core\Services;


use Decole\Hw13\Core\Dtos\EventAddDto;

class AddEventService
{
    public function addEvents(array $dtoList): void
    {
        $service = new StorageService();

        foreach ($dtoList as $dto) {
            $service->save($dto);
        }
    }

    public function createDtoList(array $events): array
    {
        $result = [];

        foreach ($events as $event) {
            $dto = new EventAddDto();
            $dto->priority = (int)$event['priority'];
            $dto->condition = $event['conditions'];
            $dto->eventType = $event['event']['type'];

            $result[] = $dto;
        }

        return $result;
    }
}