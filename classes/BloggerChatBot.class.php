<?php

require_once("ChatBotInterface.class.php");

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message as MessageObject;

/**
 * Parent Bot
 */
class BloggerChatBot implements ChatBotInterface
{
    protected Api $tgApi;
    protected array $config;
    protected TgMessage $msg;
    protected MyQueryBuilder $qb;
    protected string $botName;
    protected ChatBotLogger $logger;

    /**
     * @param string $botName
     */
    public function __construct(string $botName = '')
    {
        if (!$botName) {
            throw new \Exception("Botname is not set in BloggerChatBot class.");
        }

        $filename = __DIR__ . '/../config/' . $botName . ".ini";
        $this->config = parse_ini_file($filename, true);

        if($this->config === false) {
            throw new \Exception("Error: Bot config '{$botName}.ini' is not found.");
        }

        // Запоминаем имя бота
        $this->botName = $botName;

        // Устанавливаем токен
        $this->tgApi = new Api($this->config['bot']['api_key']);
        //$this->tgApi->addCommands([ExecCommand::class]);

        // init DB connection
        $this->qb = new MyQueryBuilder($this->config['bot']['bot_name']);

        // init Logger
        $this->logger = new ChatBotLogger($this->config);
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @return bool
     */
    public function setWebhook(): bool
    {
        $url = 'https://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?') . '?action=message'; // $this->config['bot']['webhook_url'];

        echo "Setting webhook to '$url' ...";

        $result = $this->tgApi->setWebhook(['url' => $url]);

        echo json_encode(['result' => $result]);

        return $result;
    }

    /**
     * Send raw text msg
     * @param string $reply
     * @return MessageObject
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function sendMsg(string $reply): MessageObject
    {
        return $this->tgApi->sendMessage(['chat_id' => $this->msg->getChatId(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $reply]);
    }

    /**
     * Send html-formatted msg
     * @param string $reply
     * @return MessageObject
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function sendHtmlMsg(string $reply): MessageObject
    {
        return $this->tgApi->sendMessage(['chat_id' => $this->msg->getChatId(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => false, 'text' => $reply]);
    }

    /**
     * Send msg to bot author
     * @param string $reply
     * @return MessageObject
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function sendMeMsg(string $reply): MessageObject
    {
        $myTgId = $this->config['me']['tg_user_id'];
        return $this->tgApi->sendMessage(['chat_id' => $myTgId, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $reply]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// GETTERS

    /**
     * @return string
     */
    public function getBotName(): string
    {
        return $this->botName;
    }

    /**
     * @return MyQueryBuilder
     */
    public function getQB(): MyQueryBuilder
    {
        return $this->qb;
    }

    /**
     * @return TgMessage
     */
    public function getMsg(): TgMessage
    {
        return $this->msg;
    }

    /**
     * @return Api
     */
    public function getTgApi(): Api
    {
        return $this->tgApi;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// MESSAGES HANDLING

    /**
     * Handle message from telegram
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function getMessage(): bool
    {
        $input = file_get_contents('php://input');
        $requestBody = (array)json_decode($input, true);

        if (!isset($requestBody['message'])) {
            echo "Error: Message body is empty";
            return false;
        }

        // Передаем в переменную $result полную информацию о сообщении пользователя
        $result = $this->tgApi->getWebhookUpdates();

        $msg = new TgMessage($result["message"]);
        $this->msg = $msg;

        $msgText = $this->msg->getText();
        $msgCmd = strtok($msgText, " ");

        // save msg to DB
        $msgData = [
            'text' => $msgText,
            'chat_id' => $msg->getChatId(),
            'from_username' => $msg->getFromUserName(),
            'from_userid' => $msg->getFromUserId(),
            'send_time' => date("Y-m-d H:i:s"),
            'json' => $msg->getJson()
        ];
        $this->qb->insertData('messages', $msgData);

        $cmdClass = $this->getMenuCommand($msgCmd);
        if($cmdClass) {
            $cmd = new $cmdClass($this);
        } else {
            $cmd = new DefaultCmd($this);
        }
        $ret = $cmd->run();

        echo json_encode(['success' => $ret]);

        return $ret;
    }

    /**
     * @param string $menuCmd
     * @return ?string
     */
    public function getMenuCommand(string $menuCmd): ?string
    {
        $map = [
            '/soc'       => 'SocCmd',
            '/menu'      => 'MenuCmd',
            '/start'     => 'StartCmd',
            '/about'     => 'AboutCmd',
            '/help'      => 'HelpCmd',
            '/news'      => 'NewsCmd',
            '/itnews'    => 'ItnewsCmd',
            '/pic'       => 'PicCmd',
            '/video'     => 'VideoCmd',
            '/log'       => 'LogCmd',
            '/msg'       => 'MsgCmd',
            '/stat'      => 'StatCmd',
            '/subscr'    => 'SubscrCmd',
            '/unsubscr'  => 'UnsubscrCmd',
        ];

        return (isset($map[$menuCmd]) ? $map[$menuCmd] : null);
    }

    /**
     * Starting point
     * @return void
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): void
    {
        $action = (isset($_GET['action']) ? $_GET['action'] : '');

        switch ($action) {
            case 'webhook':
                $this->setWebhook();
                break;

            case 'message':
                $this->getMessage();
                break;

            case 'test':

                // test log
                print "Testing ...\n";
                print "Write to log ...\n";
                $res = $this->logger->writeLog("Test");
                echo "Result: ";
                var_dump($res);

                // test photo
                $photo = new BlogPhoto($this->getConfig());
                echo $photo->getRandomPhoto();
                break;

            default:
                echo "Unknown action: " . $action;
                break;
        }
    }
}

/**
 * Custom classes autoloader
 * @param string $className
 * @return void
 */
function loadClasses(string $className)
{
    $dirs = ['', '../commands'];
    $exts = ['.php', '.class.php'];

    foreach($dirs as $dir) {
        foreach($exts as $ext) {
            $path = __DIR__ . "/{$dir}/" . $className . $ext;
            if (file_exists($path)) {
                require_once($path);
            }
        }
    }
}

spl_autoload_register('loadClasses');
