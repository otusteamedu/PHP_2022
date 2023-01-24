<?php

namespace Otus\Mvc\Application\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Otus\Mvc\Application\Viewer\View;
use Doctrine\DBAL\Exception;

class UserReg extends Model
{
    public $timestamps = false;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'users';

    public static function register() 
    {
        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['username']) && !empty($_POST['email'])) {
            $secure_login = htmlspecialchars($_POST['login']);
            $secure_password = htmlspecialchars($_POST['password']);
            $secure_username = htmlspecialchars($_POST['username']);
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
            if (!$user_reg = User::where('login', '=', $secure_login)->first()) {
                    if ($user_reg == null) {
                        $user = new User();
                        $hash_paswd = password_hash($secure_password, PASSWORD_BCRYPT);
                        $user->login = $secure_login;
                        $user->username = $secure_username;
                        $user->password = $hash_paswd;
                        $user->email = $secure_email;
                        try {
                            if (!$user->save()) {
                                throw new Exception("Пользователь не сохранился в базе");
                            } else {
                                $_SESSION['is_auth'] = true;
                                $_SESSION['login'] = $user->login;
                                $_SESSION['user_id'] = $user->id;
                                $_SESSION['email'] = $user->email;
                                return true;
                            }
                        } catch (\Exception $ex) {
                            $ex="Пользователь не сохранился в базе. Ошибка на сервере, проверь базу";
                            MyLogger::log_db_error();
                            View::render('error',[
                                'title' => '503 - Service Unavailable',
                                'error_code' => '503 - Service Unavailable',
                                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
                            ]);
                        }
                    }
            }
        } else {
            return false;
        }
    }
}
    

