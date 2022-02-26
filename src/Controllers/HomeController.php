<?php declare(strict_types=1);

namespace Queen\App\Controllers;

class HomeController extends DefaultController
{
    public function index()
    {
        $html = $this->renderer->render('index');
        $this->response->setContent($html);
        echo $this->response->getContent();
    }
}
