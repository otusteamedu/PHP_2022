<?php

declare(strict_types=1);

namespace Ppro\Hw28\Repository;

use function DI\string;

/**
 *
 */
class RedisRepository implements RepositoryInterface
{
    /**
     *
     */
    const STATEMENT_REQUEST_QUEUE = 'statement_queue';
    /**
     *
     */
    const STATEMENT_REQUEST_HASH_PREFIX = 'statement';
    /**
     *
     */
    const STATEMENT_REQUEST_STATUSES = [
      'pending' => 'pending',
      'processing' => 'processed',
      'success' => 'success',
      'error' => 'error',
    ];

    /**
     * @var \Redis
     */
    private \Redis $redis;

    /**
     * @param array $repoCreddle
     * @throws \RedisException
     */
    public function __construct(array $repoCreddle)
    {
        try {
            $this->redis = new \Redis();
            $this->redis->connect($repoCreddle['host'], (int)$repoCreddle['port'], 10);
        } catch (Exception $e) {
            throw new \Exception("Cannot connect to redis server:" . $e->getMessage());
        }
    }

    /** Создания заявки (постановка в очередь на обработку)
     * @param array $payload
     * @return int
     */
    public function setStatementRequest(array $payload)
    {
        $payload['requestId'] = $this->generateRequestId();
        $this->pushToQueue(self::STATEMENT_REQUEST_QUEUE,$payload);
        $this->setStatementHash($payload['requestId'],$payload);
        $this->setStatementRequestStatus($payload['requestId'],self::STATEMENT_REQUEST_STATUSES['pending']);
        return $payload['requestId'];
    }

    /** Получение заявки
     * @param int $requestId
     * @return array
     */
    public function getStatementRequest(int $requestId)
    {
        return $this->getStatementHashAll($requestId);
    }

    /** Обработка очереди заявок
     * @return mixed
     */
    public function processingStatementQueue()
    {
        while (true) {
            $payload = $this->popFromQueue(self::STATEMENT_REQUEST_QUEUE);
            if (empty($payload)) {
                sleep(10);
                continue;
            }
            $this->processStatementElement($payload);
        }
    }

    /**
     * @param string $payload
     * @return void
     */
    private function processStatementElement(string $payload)
    {
        $payload = unserialize($payload);
        $this->setStatementRequestStatus((int)$payload['requestId'],self::STATEMENT_REQUEST_STATUSES['processing']);
        $result = $this->processing($payload);
        $this->setStatementHash((int)$payload['requestId'],$result);

    }

    /**
     * @param string $queueName
     * @param $payload
     * @return mixed|\Redis
     * @throws \RedisException
     */
    private function pushToQueue(string $queueName, $payload)
    {
       return $this->redis->rawCommand('RPUSH', $queueName, serialize($payload));
    }

    /**
     * @param string $queueName
     * @return mixed|\Redis
     * @throws \RedisException
     */
    private function popFromQueue(string $queueName)
    {
        return $this->redis->rawCommand('LPOP', $queueName);
    }

    /**
     * @param int $hKey
     * @param string $status
     * @return void
     * @throws \RedisException
     */
    private function setStatementRequestStatus(int $hKey, string $status)
    {
        $this->redis->hMSet($this->getStatementHashKey($hKey), ['status' => $status]);
    }

    /**
     * @param int $hKey
     * @return string
     */
    private function getStatementHashStatus(int $hKey):string
    {
        return $this->getStatementHashFields($hKey, ['status'])['status'] ?? 'undefined';
    }

    /**
     * @param int $hKey
     * @param array $payload
     * @return void
     * @throws \RedisException
     */
    private function setStatementHash(int $hKey, array $payload)
    {
        $this->redis->hMSet($this->getStatementHashKey($hKey), $payload);
    }

    /**
     * @param int $hKey
     * @return array
     * @throws \RedisException
     */
    private function getStatementHashAll(int $hKey): array
    {
        return $this->redis->hGetAll($this->getStatementHashKey($hKey));
    }

    /**
     * @param int $hKey
     * @param array $fields
     * @return array
     * @throws \RedisException
     */
    private function getStatementHashFields(int $hKey, array $fields): array
    {
        return $this->redis->hMGet($this->getStatementHashKey($hKey),$fields);
    }

    /**
     * @param int $hKey
     * @return string
     */
    private function getStatementHashKey(int $hKey): string
    {
        return self::STATEMENT_REQUEST_HASH_PREFIX."_".$hKey;
    }

    /**
     * @return int
     * @throws \RedisException
     */
    private function generateRequestId(): int
    {
        do {
            $requestId = rand(1_000_000, 9_999_999);
        } while(!empty($this->getStatementHashAll($requestId)));
        return $requestId;
    }

    /** ... пример обработка заявки
     * @param array $payload
     * @return array
     */
    private function processing(array $payload): array
    {
        //... example
        sleep(rand(1,10));
        $status = rand(93,100) > 95;
        $payload['results'] = $status;
        $payload['status'] = self::STATEMENT_REQUEST_STATUSES[$status ? 'success' : 'error'];
        //... example
        return $payload;
    }

}