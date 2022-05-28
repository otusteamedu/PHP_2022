<?php


namespace Roman\Hw5;


class Email
{
    private ?string $email;

    public function __construct()
    {
        $this->email=$_GET['email'];
    }

    public function check_email() :array
    {
        if (isset($this->email)) {
            $email = $this->email;
            preg_match('([a-zA-Z0-9._+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)', $email, $matches);
            if (empty($matches)) {
                return array("check"=>"Некорректный эмейл", "email"=>$email);
            }
            $domain = substr(strrchr($email, "@"), 1);
            $res = getmxrr($domain, $mx_records, $mx_weight);

            if (false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"))) {
                return array("check"=>"Некорректный эмейл", "email"=>$email);
            } else {
                return array("check"=>"Корректный эмейл", "email"=>$email);
            }
        }
        return array('', '');
    }
}