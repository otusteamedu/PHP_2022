<?php

namespace Otus\App\Application\Entity\Messenger;

class MailConfigurator
{
    public static function getMailConfig()
    {
        if (!file_exists('/data/mysite.local/src/Config/config_mail.php')) {
            return false;
        } else {
            return include('/data/mysite.local/src/Config/config_mail.php');
        }
    }
}