<?php

namespace Otus\App\Application\Services;

use Otus\App\Application\Entity\Producer\BankMessage;
use Otus\App\Application\Viewer\View;

/**
 * Users requests listener
 */
class MessageForSend
{
    /**
     * Create new request + validate data
     * @return ?BankMessage
     * @throws \Exception
     */
    public static function create(): ?BankMessage
    {
        try {

            if (!empty($_POST['email']) && !empty($_POST['date_start']) && !empty($_POST['date_end'])) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $domain = substr(strrchr($email, "@"), 1);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new \InvalidArgumentException("Email aдрес не соответствует шаблону!");
                } else {
                    if (!checkdnsrr($domain, 'MX')) {
                        throw new \InvalidArgumentException("Неверный домен!");
                    } else {
                        $secure_email = $email;
                    }
                }

                if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST['date_start'])) {
                    throw new \InvalidArgumentException("Начальная дата неправильная!");
                } else {
                    $secure_date_start = new \DateTime($_POST['date_start']);
                }

                if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST['date_end'])) {
                    throw new \InvalidArgumentException("Конечная дата неправильная!");
                } else {
                    $secure_date_end = new \DateTime($_POST['date_end']);
                }

                // "Отправим выписку: с $secure_date_start по $secure_date_end на $secure_email";
                $bankMessage = new BankMessage($secure_email, $secure_date_start, $secure_date_end);

                return $bankMessage;
            }

            View::render('error', [
                'title' => '400 Bad Request ',
                'error_code' => '400 Bad Request ',
                'result' => 'Форма заполнена не корректно'
            ]);
        } catch (\InvalidArgumentException $e) {
            View::render('error', [
                'title' => '400 Bad Request ',
                'error_code' => '400 Bad Request',
                'result' => 'Причина: ' . $e->getMessage()
            ]);
        }

        return null;
    }
}
