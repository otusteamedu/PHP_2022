<?php

namespace Study\Cinema\Service;
use Exception;
use Study\Cinema\Service\Response;

class ArgumentCreator
{

    private bool|null $help;
    private string|null $message;
    public array $options;

    const OPTION_ARRAY = array(
        "title:",
        "category::",
        "price::",
        "help",
    );
    const INDEX_FIELDS = [
        "title" => ["type" => "text", "section"=>"must", "short" => "t"],
        "category" => ["type" => "phrase", "section"=>"filter", "short" => "c" ],

    ];
    const SERVICE_ARGUMENTS = [
        "help", "h"
    ];

    public function __construct()
    {
        $options = getopt('', self::OPTION_ARRAY);
        $this->setArguments($options);

    }

    public function validateServiceArguments(): bool
    {
        if($this->help) {
            throw new Exception('Используйте ключи для поиска: --title(-t) - по имени, --category(-c) - по категории. \n   '.PHP_EOL );
        }
       return true;
    }
    /*
     * Проверяет агрументы на допустимость и соответсвие типу.Создает массив валидных аргументов
     */
    public function setArguments($options): ?array
    {
        $values = [];

        foreach($options as $key => $value)
        {
            if (in_array($key, self::SERVICE_ARGUMENTS)) {

                $this->setHelp($options);
                $this->validateServiceArguments();
                return null;

            }
            elseif (array_key_exists($key, self::INDEX_FIELDS)) {

               $type = self::INDEX_FIELDS[$key]["type"];
               $method = 'check'.ucfirst($type);
               if($this->$method($value)){
                   $values[$key] = $value;
               }

           }
           else {
               throw new Exception('Недопустимое имя аргумента: ' .$key);
           }

        }
        $this->options = $values;
        return $values;
    }

    private function setHelp($options)
    {
        if(array_key_exists('h', $options) || array_key_exists('help', $options)){
            $this->help = true;
        }
        else
            $this->help = false;
    }

    public function getHelp(): bool
    {
        return $this->help;
    }
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function isFloat($value)
    {
        $float_value = (float) $value;
        if ( strval($float_value) == $value ) {
            return true;
        } else {
            return false;
        }
    }
    public function checkText($value): bool
    {
        if (mb_strlen($value) < 3) {
            throw new Exception('Недопустимое значение текстового аргумента: ' .$value. ' Должна быть строка не менее 3х символов');

        }
        return true;

    }
    public function checkPhrase($value): bool
    {
        if (mb_strlen($value) < 5 ) {
            throw new Exception('Недопустимое значение фразы: ' .$value.' Должна быть строка не менее 5х символов');
        }
        return true;

    }

}