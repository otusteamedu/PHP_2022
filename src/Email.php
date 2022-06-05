<?php

declare(strict_types=1);
namespace Roman\Hw5;


class Email
{
    /**
     * @var string|mixed|null
     */
    private ?string $email;

    /**
     * Email constructor.
     */
    public function __construct()
    {
        $this->email=$_GET['email'];
    }

    /**
     * @return array|string[]
     */
    public function check_email() :array
    {
        if(!$this->isset_email()){
            return array('', '');
        }
        if($this->empty_email() && $this->check_mx()){
            return array("check"=>"Некорректный эмейл", "email"=>$this->email);
        }
        return array("check"=>"Корректный эмейл", "email"=>$this->email);
    }

    /**
     * @return bool
     */
    private function isset_email(): bool{
        return isset($this->email);
    }

    /**
     * @return bool
     */
    private function empty_email(): bool{
        preg_match('([a-zA-Z0-9._+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)', $this->email, $matches);
        return empty($matches);
    }

    /**
     * @return bool
     */
    private function check_mx(): bool{
        $domain = substr(strrchr($this->email, "@"), 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);
        return false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"));
    }
}