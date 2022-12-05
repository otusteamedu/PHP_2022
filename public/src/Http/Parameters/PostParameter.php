<?php
declare(strict_types=1);


namespace Otus\Task\Http\Parameters;

class PostParameter
{
    public function __construct(protected array $parameters){}

    public function get(string $key){
        return array_key_exists($key, $this->parameters) ? $this->parameters[$key] : null;
    }
}