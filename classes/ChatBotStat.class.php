<?php

require_once('dbConnTrait.class.php');

/**
 * Fetch chatbot statistics
 */
class ChatBotStat
{
    private array $config;

    private \DateTime $fromDate;
    private \DateTime $toDate;

    const PERIOD_DAY        = 1;
    const PERIOD_WEEK       = 2;
    const PERIOD_MONTH      = 3;
    const PERIOD_QUARTER    = 4;
    const PERIOD_YEAR       = 5;
    const PERIOD_ALL        = 6;

    private \Pixie\QueryBuilder\QueryBuilderHandler $qb;

    use dbConnTrait;

    /**
     * Constructor
     */
    public function __construct(string $botName, int $period)
    {
        $fromDate = new \DateTime('now');
        $toDate   = new \DateTime('now');

        switch($period) {
            case self::PERIOD_DAY:
                $fromDate->sub(new DateInterval('P1D'));
                break;
            case self::PERIOD_WEEK:
                $fromDate->sub(new DateInterval('P7D'));
                break;
            case self::PERIOD_MONTH:
                $fromDate->sub(new DateInterval('P1M'));
                break;
            case self::PERIOD_QUARTER:
                $fromDate->sub(new DateInterval('P3M'));
                break;
            case self::PERIOD_YEAR:
                $fromDate->sub(new DateInterval('P1Y'));
                break;
            case self::PERIOD_ALL:
                $fromDate->sub(new DateInterval('P10Y'));
                break;
        }

        $this->fromDate = $fromDate;
        $this->toDate   = $toDate;

        $this->readConfig($botName);
        $this->connectDB();
    }

    /**
     * @param int $period
     * @return string
     */
    private function getPeriodName(int $period): string
    {
        if($period == self::PERIOD_DAY) {
            $periodName = $this->toDate->format("d.m.Y");
        } else {
            $periodName = $this->fromDate->format("d.m.Y") . ' по ' . $this->toDate->format("d.m.Y");
        }

        return  $periodName;
    }

    /**
     * Get statistics text
     * @return string
     */
    public function getStat($period = self::PERIOD_DAY): string
    {
        $periodName = $this->getPeriodName($period);

        $msgsCnt = $this->getMessagesCount($this->fromDate, $this->toDate);
        $usersCnt = $this->getUsersCount($this->fromDate, $this->toDate);

        $text  = "Статистика за {$periodName}: \n";
        $text .= "&#9997; Сообщений получено: {$msgsCnt}\n";
        $text .= "&#128587; Уникальных пользователей написало: {$usersCnt}\n";

        return $text;
    }

    /**
     * Count messages written for period
     * @param $fromDate
     * @param $toDate
     * @return int
     */
    public function getMessagesCount(\DateTime $fromDate, \DateTime $toDate): int
    {
        $query = PQB::table('messages');
        $query->where('send_time', '>=', $this->fromDate->format("Y-m-d H:i:s"));
        $query->where('send_time', '<=', $this->toDate->format("Y-m-d H:i:s"));

        $msgsCount = $query->count();
        //$msgsCount = $query->getQuery()->getRawSql();
        //die($msgsCount);

        return $msgsCount;
    }

    /**
     * Calc unique users (who wrotes a messages)
     * @param DateTime $fromDate
     * @param DateTime $toDate
     * @return int
     */
    public function getUsersCount(\DateTime $fromDate, \DateTime $toDate): int
    {
        $query = PQB::table('messages');
        $query->selectDistinct('from_userid');
        $query->where('send_time', '>=', date("Y-m-d H:i:s", $this->fromDate->getTimestamp()));
        $query->where('send_time', '<=', date("Y-m-d H:i:s", $this->toDate->getTimestamp()));
        $query->where('from_userid', '<>', 0);

        $msgsCount = count($query->get());

        return $msgsCount;
    }
}