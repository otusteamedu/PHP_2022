<?php

namespace Otus\Mvc\Application\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Otus\Mvc\Application\Viewer\View;
use Doctrine\DBAL\Exception;

class UserAuth extends Model
{
    public $timestamps = false;

    public static function login() 
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            try {
                    if ((User::all()->first()) == null) {
                        throw new Exception("Таблица с пользователями не доступна");
                    }
                } catch (\Exception $e) {
                    MyLogger::log_db_error();
                    View::render('error',[
                        'title' => '503 - Service Unavailable',
                        'error_code' => '503 - Service Unavailable',
                        'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
                    ]);
                }

            if ((User::where('login', '=', $_POST['login'])->first()) !== null) {
                foreach (User::where('login', '=', $_POST['login'])->get() as $user) {
                    $password = $_POST['password'];
                    if (password_verify($password,$user->password)) {
                        $_SESSION['is_auth'] = true;
                        $_SESSION['login'] = $user->username;
                        $_SESSION['user_id'] = $user->user_id;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['is_admin'] = intval($user->is_admin) === 1;
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    }

    public static function logout() 
    {
        if (isset($_POST['logout'])) {
            try {
                if(!session_destroy()) {
                    throw new Exception("Ошибка окончания сессии"); 
                }
            } catch(\Exception $ex) {
                MyLogger::log_db_error();
                View::render('error',[
                    'title' => '503 - Service Unavailable',
                    'error_code' => '503 - Service Unavailable',
                    'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
                ]);
            }
            return true;
        } else {
            return false;
        }
    }
}
