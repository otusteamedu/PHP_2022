<?php

declare(strict_types=1);

namespace Shilyaev\Mailchecker;

class CheckEmail
{
    protected array $domains;

    public function check(string $email) : bool
    {
        if ($this->checkRegexp($email))
        {
            $domain = explode("@", $email)[1];
            if ($this->checkMX($domain))
            {
                return true;
            }
        }
        return false;
    }

    protected function checkRegexp($email) : bool
    {
        $email = trim($email);
        if(preg_match("#.*?[<\\[\\(](.*?)[>\\]\\)].*#i", $email, $arr) && $arr[1] <> '')
        {
            $email = $arr[1];
        }

        //http://tools.ietf.org/html/rfc2821#section-4.5.3.1
        //4.5.3.1. Size limits and minimums
        if(mb_strlen($email) > 320)
        {
            return false;
        }

        //http://tools.ietf.org/html/rfc2822#section-3.2.4
        //3.2.4. Atom
        //added \p{L} for international symbols
        static $atom = "\\p{L}=_0-9a-z+~'!\$&*^`|\\#%/?{}-";
        static $domain = "\\p{L}a-z0-9-";

        //"." can't be in the beginning or in the end of local-part
        //dot-atom-text = 1*atext *("." 1*atext)
        if(preg_match("#^[{$atom}]+(\\.[{$atom}]+)*@(([{$domain}]+\\.)+)([{$domain}]{2,20})$#ui", $email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function checkMX(string $domain) : bool
    {
        if (isset($this->domains[$domain]))
            return $this->domains[$domain];

        $isMxOK = false;
        try{
            $isMxOK=checkdnsrr($domain, "MX");
        }
        catch(\Exception $exception) {
            $this->domains[$domain] = false;
            return false;
        }
        
        $this->domains[$domain] = $isMxOK;
        return $isMxOK;
    }
}