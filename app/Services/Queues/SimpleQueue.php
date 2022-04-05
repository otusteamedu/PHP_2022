<?php
/**
 * Description of SimpleQueue.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Queues;


interface SimpleQueue
{

    public function push(string $queue, string $data): void;
    public function pop(string $queue): ?string;

}
