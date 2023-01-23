<?php

require_once('vendor/autoload.php');
require_once('MyYoutubeApi.class.php');
require_once('BotCommands.class.php');
require_once('MyQueryBuilder.class.php');
require_once('ChatBotStat.class.php');
require_once('ChatBotSubscriber.class.php');

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message as MessageObject;
use Telegram\Bot\Keyboard\Keyboard;

/**
 * Parent Bot
 */
class BloggerChatBot
{
    protected Api $tgApi;
    protected array $config;
    protected TgMessage $msg;
    protected MyQueryBuilder $qb;
    protected string $botName;

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
        $this->tgApi->addCommands([ExecCommand::class]);

        // init DB connection
        $this->qb = new MyQueryBuilder($this->config['bot']['bot_name']);
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
     * Write to debug log
     * @param $this- >msg_text
     * @return bool
     */
    public function writeLog($msg_text)
    {

        $filename = $this->config['common']['log_file'];

        $fo = fopen($filename, "a");
        if ($fo == false) {
            return false;
        }

        $res = fwrite($fo, $msg_text . "\n");
        if ($res == false) {
            return false;
        }

        $res = fclose($fo);
        if ($res == false) {
            return false;
        }

        return true;
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
    /// ACTIONS

    /**
     * Show social networks list
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actSoc(): bool
    {
        $reply = "[ Список соцсетей блоггера ]";

        $this->sendMsg($reply);

        return true;
    }

    /**
     * Start action
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actStart(): bool
    {
        $name = $this->msg->getFromUsername();            // Юзернейм пользователя

        $reply = "[ Приветственный текст блоггера ]";

        $this->sendMsg($reply);

        return $this->actHelp();
    }

    /**
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     * @see unicode symbols https://unicode-table.com/ru/1F30D/
     */
    protected function actHelp(): bool
    {
        $reply = "[ Подсказки по доступным командам/меню ]";

        $this->sendMsg($reply);

        return true;
    }

    /**
     * About me (info)
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actAbout(): bool
    {
        $reply = "[ Общая инфа о блоггере ]";

        $this->sendMsg($reply);

        return true;
    }

    /**
     * Show last news list
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actNews(): bool
    {
        $news = $this->getRssNews($this->config['news']['blog_rss_url']);
        $this->sendMsg($news);

        return true;
    }

    /**
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actItNews(): bool
    {
        $news = $this->getRssNews($this->config['news']['blog2_rss_url']);
        $this->sendMsg($news);

        return true;
    }

    /**
     * Read last rss news from site
     * @return string`
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function getRssNews(string $url): string
    {
        $html = simplexml_load_file($url);
        $cnt = 0;
        $reply = "";
        foreach ($html->channel->item as $item) {
            $reply .= "&#10687; <b>" . $item->title . "</b>" . " <a href='" . $item->link . "'>\xE2\x9E\xA1</a>\n\n";
            $cnt++;
            if ($cnt > $this->config['news']['posts_limit']) {
                break;
            }
        }

        return $reply;
    }

    /**
     * Show bot dev log
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actLog(): bool
    {
        $html = file_get_contents($this->config['common']['work_file']);

        $this->sendMsg($html);

        return true;
    }

    /**
     * Return chatBot statistics
     * @return string
     */
    protected function actStat(): bool
    {
        $stat = new ChatBotStat($this->botName,ChatBotStat::PERIOD_DAY);
        $html = $stat->getStat();

        $this->sendMsg($html);

        return true;
    }

    /**
     * Subscribe user
     * @return bool
     */
    protected function actSubscr(): bool
    {
        $userId   = $this->msg->getFromUserId();
        $userName = $this->msg->getFromUserName();

        $subscr = new ChatBotSubscriber($this->botName, $userId, $userName);
        $ret = $subscr->doSubscribe();

        if($ret) {
            $this->sendMsg('Подписка успешно выполнена.');
        } else {
            $this->sendMsg('Вы уже подписаны.');
        }

        return $ret;
    }

    /**
     * @return bool
     */
    protected function actUnsubscr(): bool
    {
        $userId   = $this->msg->getFromUserId();
        $userName = $this->msg->getFromUserName();

        $subscr = new ChatBotSubscriber($this->botName, $userId, $userName);
        $ret = $subscr->doUnsubscribe();

        if($ret) {
            $this->sendMsg('Отписка успешно выполнена.');
        } else {
            $this->sendMsg('Вы не найдены среди подписчиков.');
        }

        return $ret;
    }

    /**
     * Send msg to author
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actMsg(): bool
    {
        $msgQues    = strtok("\n");
        $userId     = $this->msg->getFromUserId();
        $userName   = $this->msg->getFromUserName();

        if($msgQues) {
            // to admin
            $msgMe = "Сообщение от пользователя @$userName (#$userId): \n" . $msgQues;  //  из чата #$chatId
            $this->sendMeMsg($msgMe);
            // to user
            $msgText = "Спасибо, ваше сообщение успешно отправлено.";
            $this->sendMsg($msgText);
        } else {
            // to user
            $msgText = "Напишите ваше сообщение в формате: \n/msg текст_сообщения";
            $this->sendMsg($msgText);
        }

        return true;
    }

    /**
     * Default messagges handler
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actDefault(): bool
    {
        if (!$this->msg->getText()) {
            $reply = "Отправьте сообщение.";
        } else if (substr($this->msg->getText(), 0, 1) === '/') {
            $reply = "Неизвестная команда: \"<b>" . $this->msg->getText() . "</b>\"";
        } else {
            return $this->actHelp();
        }

        $this->sendMsg($reply);

        return true;
    }

    /**
     * @return bool
     */
    protected function actMenu(): bool
    {
        $keyboard = [];

        // read menu from .ni config. see [menu] section
        $sections = $this->config['menu'];
        foreach($sections as $sectionArr) {
            $menuArr = [];
            foreach($sectionArr as $menuItem) {
                $menuArr[] = $menuItem;
            }
            $keyboard[] = $menuArr;
        }

        $reply = "Выберите действие:";

        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);

        $this->tgApi->sendMessage(['chat_id' => $this->msg->getChatId(), 'text' => $reply, 'reply_markup' => $reply_markup]);

        return true;
    }

    /**
     * Print random picture
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actPic(): bool
    {
        $photo = new BlogPhoto($this->config);
        $url = $photo->getRandomPhoto();
        $url = $photo->savePhoto($url);
        $url = \Telegram\Bot\FileUpload\InputFile::create($url); // @see https://qna.habr.com/q/906075

        $this->tgApi->sendPhoto(['chat_id' => $this->msg->getChatId(), 'photo' => $url, 'caption' => ""]);

        return true;
    }

    /**
     * get random video from Youtube
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actVideo(): bool
    {
        if(!$this->config['youtube']['search_keywords']) {
            throw new \Exception('Не заданы ключевые слова для поиска видео в конфиге: youtube.search_keywords');
        }

        $yotubeApi = new MyYoutubeApi();
        $url = $yotubeApi->searchRandomVideo($this->config['youtube']['search_keywords']);

        $this->sendHtmlMsg($url);

        return true;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// MESSAGE HANDLING

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

        switch ($msgCmd) {

            case "/menu":
                $ret = $this->actMenu();
                break;

            case "/start":
                $ret = $this->actStart();
                $this->actMenu();
                break;

            case "/about":
                $ret = $this->actAbout();
                break;

            case "/help":
                $ret = $this->actHelp();
                break;

            case "/soc":
                $ret = $this->actSoc();
                break;

            case "/news":
                $ret = $this->actNews();
                break;

            case "/itnews":
                $ret = $this->actItNews();
                break;

            case "/pic":
                $ret = $this->actPic();
                break;

            case "/video":
                $ret = $this->actVideo();
                break;

            case "/log":
                $ret = $this->actLog();
                break;

            case "/msg":
                $ret = $this->actMsg();
                break;

            case "/stat":
                $ret = $this->actStat();
                break;

            case "/subscr":
                $ret = $this->actSubscr();
                break;

            case "/unsubscr":
                $ret = $this->actUnsubscr();
                break;

            default:
                $ret = $this->actDefault();
        }    // eof switch

        echo json_encode(['success' => $ret]);

        return $ret;
    }

    /**
     * Starting point
     * @return void
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run()
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
                $res = $this->writeLog("Test");
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