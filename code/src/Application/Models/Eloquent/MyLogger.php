<?php

namespace Otus\Mvc\Application\Models\Eloquent;

use Psr\Log\LogLevel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;

class MyLogger
{
    public $ex;


    public static function log_user_auth()
    {
        $log = new Logger('users_log');
        $log->pushHandler(new StreamHandler('../log/user_event.log', LogLevel::ERROR));
        $log->error('Ошибка входа в систему пользователем ' .$_POST['username']);
    }

    public static function log_user_reg()
    {
        $log = new Logger('users_log');
        $log->pushHandler(new StreamHandler('../log/user_event.log', LogLevel::ERROR));
        $log->error('Пользователь не смог зарегистрироваться');
    }


    public static function log_task_created()
    {
        $log = new Logger('task_log');
        $log->pushHandler(new StreamHandler('../log/race_event.log', LogLevel::ERROR));
        $log->error('Ошибка при создании гонки! Пользователь ошибся!');
    }

    public static function log_db_error()
    {
        $ex=0; 
        $log = new Logger('db_log');
        $log->pushHandler(new StreamHandler('../log/db_error.log', LogLevel::ERROR));
        $log->error('Необходимо проверить базу данных. Код ошибки: ' .$ex);
    }

}