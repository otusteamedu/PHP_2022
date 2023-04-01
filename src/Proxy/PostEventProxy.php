<?php

namespace Otus\Task14\Proxy;

use Otus\Task14\Proxy\Contract\PostEventProxyInterface;

class PostEventProxy implements PostEventProxyInterface
{
    public function __construct(private readonly PostEvent $postEvent){}

    public function getProductStandard(): void
    {
        if(!$this->hasProductStandard()){
            echo $this->postEvent->getProduct()->getName() . ' не соответствует нашему стандарту' . PHP_EOL;
        }
    }

    public function hasProductStandard(): bool
    {
        return (bool) rand(0,1);
    }
}