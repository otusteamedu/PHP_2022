<?php

namespace Otus\Mvc\Application\Models\Configurators;

class MailConfigurator
{
    public static function getMailConfig()
    {
        if (!file_exists(__DIR__.'/../../../Config/config_mail.php')) {
            return false;
        } else {
            return include(__DIR__.'/../../../Config/config_mail.php');
        }
    }
}