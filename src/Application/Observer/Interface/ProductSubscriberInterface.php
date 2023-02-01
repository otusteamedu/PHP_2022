<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Observer\Interface;

use DKozlov\Otus\Domain\Model\Interface\ProductInterface;

interface ProductSubscriberInterface
{
    public function update(ProductInterface $product): void;
}