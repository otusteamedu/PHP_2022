<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Contracts\Events;

use Src\Sandwich\Domain\Contracts\BasicProduct;

interface CookingTraceability
{
    /**
     * @param BasicProduct $basic_product
     * @return mixed
     */
    public function subscribe(BasicProduct $basic_product);

    /**
     * @param BasicProduct $basic_product
     * @return mixed
     */
    public function unsubscribe(BasicProduct $basic_product);

    /**
     * @param string $event_name
     * @return mixed
     */
    public function notifySubscribers(string $event_name);
}
