<?php

namespace Otus\Task14\Proxy;

use Otus\Task14\Factory\Contract\ProductInterface;
use Otus\Task14\Proxy\Contract\PostEventProxyInterface;

class PostEvent implements PostEventProxyInterface
{

    public function __construct(private  readonly ProductInterface $product)
    {
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getProductStandard(): void
    {
        // TODO: Implement getProductStandard() method.
    }




}