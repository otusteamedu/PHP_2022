<?php

class StatCmd extends BaseCmd
{
    const ALLOWED_PERIODS = [
        1 => 'D',
        2 => 'W',
        3 => 'M',
        4 => 'Q',
        5 => 'Y',
    ];

    /**
     * Return chatBot statistics
     * @return string
     */
    public function run(): bool
    {
        $period = trim(substr($this->bot->getMsg()->getText(), 6));

        if($period != '' && !in_array($period, self::ALLOWED_PERIODS)) {
            $html = "Не известный тип аргумента: {$period}. \nДоустимые значения: " . implode(", ", self::ALLOWED_PERIODS);
        } else {
            $intPeriod = array_search($period, self::ALLOWED_PERIODS);
            $stat = new ChatBotStat($this->bot->getBotName(),$intPeriod);
            $html = $stat->getStat();
        }

        $this->bot->sendMsg($html);

        return true;
    }

}