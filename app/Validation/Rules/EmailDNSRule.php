<?php
declare(strict_types=1);

namespace Otus\Task06\App\Validation\Rules;

use Otus\Task06\Core\Validation\Rules;

class EmailDNSRule extends Rules
{
    private const TRUSTED_DOMAINS = [
        'gmail.com', 'mail.com',
    ];

    public function validate() : bool
    {
       [,$hostname] = explode('@', $this->getValue());

       if(in_array($hostname, self::TRUSTED_DOMAINS)) return true;

       return checkdnsrr($hostname);
    }

    public function message() : string
    {
        return  sprintf('Почта "%s" не прошла валидацию.', $this->value) ;
    }

}