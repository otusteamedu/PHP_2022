<?php

namespace Roman\Hw5;

class App
{

    public function run()
    {
        list($check, $email) = $this->check_email();
        echo $this->template('layouts/form.php', ['check' => $check, 'email' => $email]);
    }

    private function check_email()
    {
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            preg_match('([a-zA-Z0-9._+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)', $email, $matches);
            if (empty($matches)) {
                return array("Некорректный эмейл", $email);
            }
            $domain = substr(strrchr($email, "@"), 1);
            $res = getmxrr($domain, $mx_records, $mx_weight);

            if (false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"))) {
                return array("Некорректный эмейл", $email);
            } else {
                return array("Корректный эмейл", $email);
            }
        }
        return array('', '');
    }

    private function template($view, $data)
    {
        extract($data);
        ob_start();
        require $view;
        $output = ob_get_clean();
        return $output;
    }

}