<?php

class StatCmd extends BaseCmd
{
    /**
     * Return chatBot statistics
     * @return string
     */
    public function run(): bool
    {
        $stat = new ChatBotStat($this->bot->getBotName(),ChatBotStat::PERIOD_DAY);
        $html = $stat->getStat();

        $this->bot->sendMsg($html);

        return true;
    }

}