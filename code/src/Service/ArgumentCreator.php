<?php

namespace Study\Cinema\Service;


class ArgumentCreator
{
    private string|null $title;
    private string|null $category;
    private string|null $price;
    private bool|null $help;
    private string|null $message;
    const OPTION_STRING = "t:c::p::h";
    const OPTION_ARRAY = array(
        "title:",
        "category::",
        "price::",
        "help",
    );

    public function __construct()
    {
        $options = getopt(self::OPTION_STRING, self::OPTION_ARRAY);

        $this->setTitle($options);
        $this->setCategory($options);
        $this->setHelp($options);
        $this->setPrice($options);

    }

    public function validate(): bool
    {
        if($this->help) {
            $this->setMessage('Используйте ключи для поиска: --title(-t) - по имени, --category(-c) - по категории. \n   '.PHP_EOL);
            return false;
        }
        else if(!$this->title) {
            $this->setMessage( 'Параметр --title(-t) обязательный.'.PHP_EOL);
            return false;
        }

        if($this->price && !$this->isFloat($this->price)){
            $this->setMessage( 'Параметр --price(-p) должен быть числом.'.PHP_EOL);
            return false;
        }

        return true;

    }

    private function setCategory($options)
    {
        $this->category = $options['c'] ?? $options['category'] ?? null;
    }

    private function setTitle($options)
    {
        $this->title =  $options['t'] ?? $options['title'] ?? null;
    }
    private function setMessage($text)
    {
        $this->message = $text;
    }

    private function setHelp($options)
    {
        if(array_key_exists('h', $options) || array_key_exists('help', $options)){
            $this->help = true;
        }
        else
            $this->help = false;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }
    public function getHelp(): bool
    {
        return $this->help;
    }
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setPrice($options): void
    {
        $this->price = $options['p'] ?? $options['price'] ?? null;
    }
    public function getPrice()
    {
        return $this->price;
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



}