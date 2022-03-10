<?php

namespace hw4\core;

use hw4\controllers\MainController;

class App
{
    protected string $basePath = '';
    protected string $publicDir = '/public/';
    protected string $projectDir = '/src/';
    protected string $viewsDir = 'views';
    protected string $baseLayout = 'layout';

    public function __construct(
        public MainController $controller,
        public Request $request,
        public Response $response,
        array $config = []
    )
    {
        $this->loadConfig($config);
        $this->setUpController();
    }

    /**
     * Обрабатываем запрос
     * @return void
     */
    public function run()
    {
        $response = $this->response;

        try {
            $responseBody = match ($this->request->getMethod()) {
                'GET' => $this->controller->actionGet(),
                'POST' => $this->controller->actionPost(),
            };
            $response->createResponse($responseBody);
        } catch (Exception $e) {
            $response->createResponse($e->getMessage(), $e->getCode());
        } finally {
            $response->send();
        }
    }

    private function setUpController()
    {
        $this->controller->viewsDir = $this->projectDir . $this->viewsDir . '/';
        $this->controller->layout = $this->baseLayout;
    }

    private function loadConfig($config = [])
    {
        foreach ($config as $attribute => $value) {
            $this->$attribute = $value;
        }
    }
}