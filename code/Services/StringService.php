<?php

namespace Otus\Mvc\Services;

use Otus\Mvc\Core\View;
use Otus\Mvc\Models\Email;
use Otus\Mvc\Models\Mystring;

class StringService
{

    public static function checkStringServ()
    {
        if (!empty($_POST['filter_string'])) {
            if (MyString::check()) {
                View::render('info', [
                    'title' => 'Страница проверки строки',
                    'mystring' => $_POST['filter_string'],
                    'result_string' => 'Количество скобочек верно'
                ]);
            } else {
                View::render('info', [
                    'title' => 'Страница проверки строки',
                    'mystring' => $_POST['filter_string'],
                    'result_string' => 'Количество скобочек НЕ верно'
                ]);
            }
        } else {
            if (MyString::check()) {
                View::render('info', [
                    'title' => 'Страница проверки строки',
                    'mystring' => $_POST['filter_string'],
                    'result_string' => 'Строка пустая'
                ]);
            }
        }
    }

    public static function checkEmailServ()
    {
        if (Email::check()) {
            View::render('info', [
                'title' => 'Страница проверки email',
                'email' => $_POST['check_email'],
                'result_email' => 'Email корректный'
            ]);
        } else {
            View::render('info', [
                'title' => 'Страница проверки email',
                'email' => $_POST['check_email'],
                'result_email' => 'Email НЕ корректный'
            ]);
        }
    }



}