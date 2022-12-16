<?php

namespace app\components;

class Error
{
     public function show($message, $code) {
         http_response_code($code);
         return 'Ошибка: '.$message;
     }

}
