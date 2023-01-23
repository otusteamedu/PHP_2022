<?php

/**
 * Mishaikon news bot
 * @see https://habr.com/ru/company/netologyru/blog/326174/
 */

declare(strict_types = 1);
ini_set("display_errors", '1');
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('classes/MyYoutubeApi.class.php');
require_once('classes/TgMessage.class.php');
require_once('classes/BlogPhoto.class.php');
require_once('classes/BloggerChatBot.class.php');
require_once('classes/MishaikonChatBot.class.php');

$bot = new MishaikonChatBot('mishaikon_bot');
$bot->run();
