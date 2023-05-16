<?php

namespace Rehkzylbz\OtusHw4;

class ResponseProvider {

    private $_response_code = 0;
    private $_response_text = 0;

    const GOOD_CODE = 200;
    const BAD_CODE = 400;
    const GOOD_TEXT = 'Всё хорошо - строка корректна ' . PHP_EOL;
    const BAD_TEXT = 'Всё плохо - строка не корректна или пуста' . PHP_EOL;

    public function __construct(bool $status = false) {
        $this->_response_code = $status ? self::GOOD_CODE : self::BAD_CODE;
        $this->_response_text = $status ? self::GOOD_TEXT : self::BAD_TEXT;
    }

    public function send(string $message = ''): void {
        http_response_code($this->_response_code);
        echo $this->_response_text;
        echo $message;
    }

}
