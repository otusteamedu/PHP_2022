<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Output\Telegram;

use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Output\Log\Logger;

class ApiBot
{
    private string $chatId;
    private string $apiId;
    private string $apiHash;

    public function __construct(string $apiId, string $apiHash, string $chatId)
    {
        $this->apiId = $apiId;
        $this->apiHash = $apiHash;
        $this->chatId = $chatId;
    }

    public function sendMessage(string $message): void
    {
        $url = $this->buildUrl("sendMessage", array("text" => $message));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        Logger::log(curl_exec($ch));

        curl_close($ch);
    }

    private function buildUrl(string $method, array $param): string
    {
        $query = $this->prepareQuery($param);

        return "https://api.telegram.org/bot$this->apiId:$this->apiHash/$method?$query";
    }

    private function prepareQuery(array $param): string
    {
        return http_build_query(
            array("chat_id" => $this->chatId, ...$param)
        );
    }
}