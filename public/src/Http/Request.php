<?php
declare(strict_types=1);

namespace Otus\Task\Http;

use Otus\Task\Http\Parameters\PostParameter;

class Request
{
    public ?PostParameter $post = null;

    protected function __construct(array $post){
        $this->post = new PostParameter($post);
    }

    public static function create(): static
    {
        return new static($_POST);
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

}