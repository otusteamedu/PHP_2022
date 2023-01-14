<?php

declare(strict_types=1);

namespace Chernysh\EmailVerification;

use Chernysh\EmailVerification\Service\{EmailVerification, ServiceException};
use Exception;

class App
{

    /**
     * @throws Exception
     */
    public function run(): array
    {
        if (isset($_REQUEST['emails'])) {
            // Указываем набор emails через параметры запроса
            $emails = explode(',', $_REQUEST['emails']);
        } else {
            // Либо указываем тестовый набор
            $emails = [
                'mihail.chernysh@gmail.com',
                'foobar@otus.ru',
                'qwe@foobar.ru',
                'rty@er.tu',
            ];
        }

        if (!$emails) {
            throw new Exception('Параметр $emails не может быть пустым');
        }

        $results = [];
        $service = new EmailVerification();

        foreach ($emails as $email) {
            try {
                $service->check($email);
                $results[$email] = ' OK ';
            } catch (ServiceException $e) {
                $results[$email] = $e->getMessage();
            }
        }

        return $results;
    }

}