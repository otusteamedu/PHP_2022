
   
<?php

declare(strict_types=1);

namespace Igor\Hw4;

use Exception;
use Igor\Hw4\HTTP\Request;
use Igor\Hw4\HTTP\Response;

class BracketValidation
{
    public function __construct()
    {
        // устанавливаем свойства класса
        $this->request      = new Request();
        $this->response  = new Response();
        if (!$this->request->isPost()) {
            $this->response->setContent('Метод должен быть POST');
        }
    }

    public function run()
    {
        try{
            $string = $_POST['string'];
            
            if (!$string) {   
                throw new \Exception('Строка пустая', 400);               
            }
    
            $counter = 0;
    
            $openBracket = ['('];
            $closedBracket = [')'];
    
            $length = strlen($string);
    
            for ($i = 0; $i < $length; $i++) {
                $char = $string[$i];
    
                if (in_array($char, $openBracket)) {
                    $counter++;
                } elseif (in_array($char, $closedBracket)) {
                    $counter--;
                }
            }
    
            if ($counter != 0) {               
                throw new \Exception('Строка не валидна', 400);          
            }
            
            $this->response->setContent('Строка валидна');
        } catch ( Exception $e){
            $this->response->setContent($e->getMessage());
            $this->response->setStatusCode($e->getCode()); 
        } finally {
            return $this->response->send();
        }   
    }
}