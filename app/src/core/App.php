<?php

namespace nka\otus\core;


use nka\otus\core\exceptions\ApplicationException;
use Psr\Container\ContainerInterface;

class App extends Component
{
    protected string $basePath   =  '';
    protected string $publicDir  =  '/public/';
    protected string $projectDir =  '/src/';
    protected string $modulesDir =  'modules';
    protected string $viewsDir   =  'views';
    protected string $baseLayout =  'layout';
    protected array $pathConfig  =  [];
    protected ContainerInterface $container;

    public function __construct(
        public Request           $request,
        public Response          $response,
        protected RequestHandler $handler,
        array                    $config = []
    )
    {
        $this->loadParams($config);
        $this->setPathConfig();
    }

    /**
     * Обрабатываем запрос
     * @return void
     */
    public function run()
    {
        $response = $this->response;

        try {
            $response->createResponse(
                $this->handler->handle(
                    $this->getContainer(),
                    $this->getPathConfig()
                )
            );
        } catch (ApplicationException $e) {
            $response->createResponse($e->getMessage(), $e->getCode());
        }
        $response->send();
    }

    private function setPathConfig()
    {
        $this->pathConfig = [
            'layoutDir' => $this->projectDir . $this->viewsDir . '/',
            'layout' => $this->baseLayout,
            'projectDir' => $this->projectDir,
            'viewsDir' => $this->viewsDir
        ];
    }

    private function getPathConfig(): array
    {
        return $this->pathConfig;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}