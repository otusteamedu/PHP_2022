<?php

namespace Otus\Task10\Core\Http;

use Otus\Task10\Core\Http\Parameters\PostParameter;

class HttpRequest extends Request
{
    public ?PostParameter $post = null;

    public function __construct(array $post){
        $this->post = new PostParameter($post);
    }

    public function initialize()
    {
        $this->post = new PostParameter($_POST);

    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function getPath()
    {
        // TODO: Implement getPath() method.
    }
}