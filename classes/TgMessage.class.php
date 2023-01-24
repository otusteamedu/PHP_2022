<?php

/**
 * Telegram message
 */
class TgMessage
{
    private string $text;
    private int $chat_id;
    private string $fromUsername;
    private int $fromUserid;
    private string $json;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        // Текст сообщения
        $this->text = $params["text"];

        // Уникальный идентификатор чата
        $this->chat_id = $params["chat"]["id"];

        // message sender username
        $this->fromUsername = (isset($params["from"]["username"]) ? $params["from"]["username"] : '');

        // message sender id
        $this->fromUserid = (isset($params["from"]["id"]) ? $params["from"]["id"] : 0);

        // save origina msg as json
        $json = json_encode($params);
        $this->json = ($json ?: null);
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chat_id;
    }

    /**
     * @return string
     */
    public function getFromUserName(): string
    {
        return $this->fromUsername;
    }

    /**
     * @return int
     */
    public function getFromUserId(): int
    {
        return $this->fromUserid;
    }

    /**
     * @return mixed|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed|string
     */
    public function getJson()
    {
        return $this->json;
    }
}
