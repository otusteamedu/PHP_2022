<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw4;

class App {
    
    /**
     * 
     * @param string $default_string
     * @return void
     */
    public function run(string $default_string = ''): void {
        $session = (new SessionProvider('memcached'))->start();
        $string = (new RequestProvider())->get_post_parameter('string', ')(');
        $validation = (new StringValidator())->is_valid_parenthesis($string);
        (new ResponseProvider($validation))->send($session->get_info_message());
    }

}
