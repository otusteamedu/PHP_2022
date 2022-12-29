<?php

namespace Otus\App\Application\Services;

use Otus\App\Application\Viewer\View;

class MessageForSend
{
  public static function create()
  {
      try {
          if (!empty($_POST['email']) &&
              !empty($_POST['date_start']) &&
              !empty($_POST['date_end'])) {

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
                      $secure_date_start = htmlspecialchars($_POST['date_start']);
                  }
                  if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST['date_end'])) {
                      throw new \InvalidArgumentException("Конечная дата неправильная!");
                  } else {
                      $secure_date_end = htmlspecialchars($_POST['date_end']);
                  }

                  //$secure_msg = "Отправим выписку: с $secure_date_start по $secure_date_end на $secure_email";
                  $secure_msg = array($secure_email, $secure_date_start, $secure_date_end);
                  return $secure_msg;
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
              'result' => 'Причина: '. $e->getMessage()
          ]);
      }
  }
}