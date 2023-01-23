<?php

/**
 * Subscriber
 */

class ChatBotSubscriber
{
    private string $userName;
    private int $userId;
    private MyQueryBuilder $qb;

    /**
     * Constructor
     * @param string $botName
     * @param int $userId
     * @param string $userName
     * @throws Exception
     */
    public function __construct(string $botName, int $userId, string $userName = '')
    {
        $this->userId   = $userId;
        $this->userName = $userName;
        $this->qb = new MyQueryBuilder($botName);
    }

    /**
     * @param string $userid
     * @return void
     */
    public function findSubscriber(string $userId): array
    {
        $exist = $this->qb->getData('subscribers', ['id'], [['userid', '=', $userId]]);

        return $exist;
    }

    /**
     * @param string $userName
     * @return array
     */
    public function findSubscriberByName(string $userName): array
    {
        $exist = $this->qb->getData('subscribers', ['id'], [['username', '=', $userName]]);

        return $exist;
    }

    /**
     * Subscribe user
     * @return bool
     */
    public function doSubscribe(): bool
    {
        $now = new DateTime('now');
        $now = $now->format("Y-m-d H:i:s");

        $existId = $this->findSubscriber($this->userId);
        if($existId) {
            return false;
        }

        $existName = $this->findSubscriberByName($this->userName);
        if($existName) {
            return false;
        }

        $data = [
            'userid' => $this->userId,
            'username' => $this->userName,
            'subscr_date' => $now,
        ];
        $this->qb->insertData('subscribers', $data);

        return true;
    }

    /**
     * Unsubscribe user
     * @return bool
     */
    public function doUnsubscribe(): bool
    {
        $existId = $this->findSubscriber($this->userId);
        $existName = $this->findSubscriberByName($this->userName);

        if(!$existId && !$existName) {
            return false;
        }

        $this->qb->deleteData('subscribers', [['userid', '=', $this->userId]]);
        $this->qb->deleteData('subscribers', [['username', '=', $this->userName]]);

        return true;
    }
}