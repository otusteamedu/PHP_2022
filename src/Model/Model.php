<?php
declare(strict_types=1);

namespace App\Model;

use App\Common\Config;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPMailer\PHPMailer\PHPMailer;

class Model
{
    protected $config;
    protected $messenger;

    public function __construct(ConfigInterface $config, SendMessageInterface $messenger)
    {
        $this->config = $config;
        $this->messenger = $messenger;
    }

    public function consumerStart(): array
    {
        exec("/usr/local/bin/php ".dirname(__FILE__)."/../Consumers/BankReportsGenerator.php > /dev/null 2>&1 &");
        return [];
    }

    public function consumerStop()
    {
        list($connection, $channel) = $this->openConnection();
        $msg = new AMQPMessage( 'stop');
        $channel->basic_publish($msg, '', $this->config->get('queue')["routing_key"]);
        $this->closeConnection($channel, $connection);
    }

    public function startReportGenerator(string $date_start = "", string $date_end ="", string $email="")
    {
        $errors=[];
        if (!preg_match("/^(0[1-9]|[12][0-9]|3[01])[\.](0[1-9]|1[012])[\.](19|20)\d\d$/", $date_start))
            $errors[]="Проверьте начальную дату!";
        if (!preg_match("/^(0[1-9]|[12][0-9]|3[01])[\.](0[1-9]|1[012])[\.](19|20)\d\d$/", $date_end))
            $errors[]="Проверьте кончную дату!";
        if (strtotime($date_start)>strtotime($date_end))
            $errors[]="Проверьте диапазон дат!";
        if(!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $email))
            $errors[]="Проверьте email!";
        if (empty($errors)) {
            list($connection, $channel) = $this->openConnection();
            $channel->queue_declare($this->config->get('queue')["queue"], false, false, false, false);
            $msg = new AMQPMessage(json_encode(['dateStart' => $date_start, 'dateEnd' => $date_end, 'email' => $email]));
            $channel->basic_publish($msg, '', $this->config->get('queue')["routing_key"]);
            $this->closeConnection($channel, $connection);
        }
        return ['errors'=>$errors];
    }

    public function generateReport(string $date_start = "", string $date_end ="", string $email="")
    {
        if (!preg_match('/^([01]?[0-9]|2[0-3])(:|\.)[0-5][0-9]$/', $date_start))
            new \InvalidArgumentException("Wrong date_start!");
        if (!preg_match('/^([01]?[0-9]|2[0-3])(:|\.)[0-5][0-9]$/', $date_end))
            new \InvalidArgumentException("Wrong date_end!");
        if (strtotime($date_start)>strtotime($date_end))
            new \InvalidArgumentException("Wrong date range!");
        if(preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email))
            new \InvalidArgumentException("Wrong email!");

        $to      = $email;
        $subject = "Bank report from $date_start to $date_end";
        $message = "Simple dummy report: from $date_start to $date_end";

        $this->messenger->send($to, $message, $subject);
    }

    public function processMessage ($msg) {

        if ($msg->body=="stop")
            die;

        $data=json_decode($msg->body, true);
        if (is_array($data))
        {
            try {
                $this->generateReport($data['dateStart'], $data['dateEnd'], $data['email']);
            }
            catch (Throwable $e)
            {
                //TODO: Log it!
            }
        }
    }

    public function startListener()
    {
        list($connection, $channel) = $this->openConnection();
        $channel->basic_consume($this->config->get('queue')["queue"], '', false, true, false, false, array($this, 'processMessage'));
        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

    /**
     * @return array
     */
    protected function openConnection(): array
    {
        $connection = new AMQPStreamConnection($this->config->get('rabbit-mq')["host"], $this->config->get('rabbit-mq')["port"], $this->config->get('rabbit-mq')["user"], $this->config->get('rabbit-mq')["password"]);
        $channel = $connection->channel();
        $channel->queue_declare($this->config->get('queue')["queue"], false, false, false, false);
        return array($connection, $channel);
    }

    /**
     * @param $channel
     * @param $connection
     * @return void
     */
    protected function closeConnection($channel, $connection): void
    {
        $channel->close();
        $connection->close();
    }
}