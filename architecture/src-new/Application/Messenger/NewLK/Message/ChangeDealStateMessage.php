<?php

namespace App\Application\Messenger\NewLK\Message;

use App\Application\Messenger\Common\Message\FailureNotificationMessageInterface;
use new\Domain\Enum\NewLK\DealState;
use Ramsey\Uuid\UuidInterface;

/**
 * Сообщение для изменения статуса сделки в NewLK
 */
class ChangeDealStateMessage implements FailureNotificationMessageInterface
{
    private DealState $state;
    private string $applicationId;
    private string $dealId;
    private UuidInterface $bankUuid;
    private ?string $comment;

    public function __construct(
        string $applicationId,
        string $dealId,
        UuidInterface $bankUuid,
        DealState $state,
        ?string $comment = null
    ) {
        $this->state = $state;
        $this->applicationId = $applicationId;
        $this->dealId = $dealId;
        $this->bankUuid = $bankUuid;
        $this->comment = $comment;
    }

    public function getDealId(): string
    {
        return $this->dealId;
    }

    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    public function getState(): DealState
    {
        return $this->state;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getBankUuid(): UuidInterface
    {
        return $this->bankUuid;
    }

    public function getFailureMessage(): string
    {
        return sprintf(
            'Не удалось отправить статус %s в NewLK для сделки %s',
            $this->state->getTitle(),
            $this->dealId
        );
    }
}
