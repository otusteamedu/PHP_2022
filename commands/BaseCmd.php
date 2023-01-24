<?php

require_once("CmdInterface.php");

/**
 * Base (abstract) command
 */

class BaseCmd implements CmdInterface
{
    protected array $config;
    protected BloggerChatBot $bot;

    /**
     * @param string $botName
     */
    public function __construct(BloggerChatBot $bot)
    {
        $this->bot = $bot;
        $this->config = $bot->getConfig();
    }

    /**
     * @return bool
     */
    public function run(): bool
    {
        return true;
    }
}