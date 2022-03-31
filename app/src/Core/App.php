<?php

namespace Nka\Otus\Core;


use DI\ContainerBuilder;
use Nka\Otus\Core\Exceptions\ApplicationException;
use Nka\Otus\Core\Http\RequestHandler;
use Nka\Otus\Core\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class App extends Component
{
    protected string $basePath   =  '';
    protected string $publicDir  =  '/public/';
    protected string $projectDir =  '/src/';
    protected string $modulesDir =  'Modules';
    protected string $viewsDir   =  'Views';
    protected string $baseLayout =  'layout';
    protected array $pathConfig  =  [];
    protected ContainerInterface $container;


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function init($definition) : App
    {
        $appContainer = self::buildContainer($definition);
        /**
         * @var App $app
         */
        $app = $appContainer->get('app');
        $app->setContainer($appContainer);

        return $app;
    }

    /**
     * @throws Exceptions\WrongAttributeException
     */
    public function __construct(
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

    private static function buildContainer($definition): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($definition);
        return $containerBuilder->build();
    }

    private function setPathConfig()
    {
        $this->pathConfig = [
            'layoutDir'  => $this->projectDir . $this->viewsDir . '/',
            'layout'     => $this->baseLayout,
            'projectDir' => $this->projectDir,
            'viewsDir'   => $this->viewsDir
        ];
    }

    private function getPathConfig(): array
    {
        return $this->pathConfig;
    }

    private function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    private function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}