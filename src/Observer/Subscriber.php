<?php

namespace Patterns\Observer;

class Subscriber implements ObserverInterface
{
    public string $name;


    public function __construct(string $name)
    {
        $this->name = $name;
    }


    public function handleEvent(array $vacancies): string
    {
        return "Здравствуйте, {$this->name}! На сайте появились новые вакансии" . implode(', ', $vacancies) . PHP_EOL . PHP_EOL;
    }
}
