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
     * @param int $isActive
     * @return void
     */
    public function findSubscriber(string $userId, int $isActive = 1): array
    {
        $exist = $this->qb->getData('subscribers', ['id'], [['userid', '=', $userId], ['is_active', '=', $isActive]]);

        return $exist;
    }

    /**
     * @param string $userName
     * @param int $isActive
     * @return array
     */
    public function findSubscriberByName(string $userName, int $isActive = 1): array
    {
        $exist = $this->qb->getData('subscribers', ['id'], [['username', '=', $userName], ['is_active', '=', $isActive]]);

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

        $existId = $this->findSubscriber($this->userId, 1);
        if($existId) {
            return false;
        }

        $existName = $this->findSubscriberByName($this->userName, 1);
        if($existName) {
            return false;
        }

        $existId = $this->findSubscriber($this->userId, 0);
        if($existId) {
            $this->qb->deleteData('subscribers', [['userid', '=', $this->userId]]);
        }

        $existName = $this->findSubscriberByName($this->userName, 0);
        if($existName) {
            $this->qb->deleteData('subscribers', [['username', '=', $this->userName]]);
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
        $existId = $this->findSubscriber($this->userId, 1);
        $existName = $this->findSubscriberByName($this->userName, 1);

        if(!$existId && !$existName) {
            return false;
        }

        $this->qb->updateData('subscribers', ['is_active' => 0], [['userid', '=', $this->userId]]);
        $this->qb->updateData('subscribers', ['is_active' => 0], [['username', '=', $this->userName]]);

        return true;
    }
}