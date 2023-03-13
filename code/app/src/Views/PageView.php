<?php

namespace Ppro\Hw27\App\Views;

use Ppro\Hw27\App\Application\Request;

class PageView implements ViewInterface
{
    private string $template;
    private Request $request;

    public function __construct(string $template)
    {
        $this->template = $template;
    }

    public function render(Request $request)
    {
        $this->request = $request;
        $content = $this->prepareContent();

        $this->getHeader($content);
        $this->getBody($content);
        $this->getFooter($content);
    }

    private function prepareContent()
    {
        $content = $this->request->getContent();
        $content['feedbackString'] = $this->request->getFeedbackString();

        return $content;
    }

    private function getHeader($content)
    {
        include( __DIR__ . "/Templates/header.php");
    }

    private function getBody($content)
    {
        $filePath = __DIR__ . "/".$this->template.".php";
        if(file_exists($filePath))
            include($filePath);
    }

    private function getFooter($content)
    {
        include( __DIR__ . "/Templates/footer.php");
    }
}