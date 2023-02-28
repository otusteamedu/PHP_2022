<?

declare(strict_types=1);

namespace Kogarkov\Es\Model;

class EventModel
{
    private $priority;
    private $conditions;
    private $event;

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getEvent(): string
    {
        return json_encode([
            'conditions' => $this->conditions,
            'event' => $this->event,
        ]);
    }

    public function fromJson(string $data): EventModel
    {
        $event = json_decode($data, true);
        if (empty($event['priority'])) {
            throw new \Exception('priority is empty');
        }
        if (empty($event['conditions'])) {
            throw new \Exception('conditions is empty');
        }
        if (empty($event['event'])) {
            throw new \Exception('event is empty');
        }
        $this->priority = $event['priority'];
        $this->conditions = $event['conditions'];
        $this->event = $event['event'];

        return $this;
    }

    public function asArray(): array
    {
        return [
            'priority' => $this->priority,
            'conditions' => $this->conditions,
            'event' => $this->event
        ];
    }

    public function asJson(): string
    {
        return json_encode([
            'priority' => $this->priority,
            'conditions' => $this->conditions,
            'event' => $this->event
        ]);
    }
}
