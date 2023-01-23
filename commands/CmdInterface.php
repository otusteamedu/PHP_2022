<?php

/**
 * Command interface
 */
interface CmdInterface
{
    /**
     * @param BloggerChatBot $bot
     */
    public function __construct(BloggerChatBot $bot);

    /**
     * @return bool
     */
    public function run(): bool;
}