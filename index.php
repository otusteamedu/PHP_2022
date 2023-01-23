<?php

/**
 * Mishaikon news bot
 */

declare(strict_types = 1);
ini_set("display_errors", '1');
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('classes/BloggerChatBot.class.php');

$bot = new BloggerChatBot('mishaikon_bot');
$bot->run();
