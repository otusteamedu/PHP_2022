<?php

namespace Queen\App\Controllers;

use Queen\App\Core\Http\HttpRequest;
use Queen\App\Core\Http\HttpResponse;
use Queen\App\Core\Template\Renderer;

class DefaultController
{
    protected HttpRequest $request;
    protected HttpResponse $response;
    protected Renderer $renderer;

    public function __construct(
        HttpRequest $request,
        HttpResponse $response,
        Renderer $renderer
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
    }

    public function render($view, $param = [])
    {
        $html = $this->renderer->render($view, $param);
        $this->response->setContent($html);
        echo $this->response->getContent();
    }
}
