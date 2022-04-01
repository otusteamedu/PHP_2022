<?php

namespace Nka\Otus\Core;


use DI\ContainerBuilder;
use Nka\Otus\Core\Exceptions\ApplicationException;
use Nka\Otus\Core\Exceptions\CoreException;
use Nka\Otus\Core\Http\RequestHandler;
use Nka\Otus\Core\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class App extends Component
{
    protected static string $bootstrap = 'bootstrap.php';

    protected ContainerInterface $container;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function init(): App
    {
        $appContainer = self::buildContainer();
        /**
         * @var App $app
         */
        $app = $appContainer->get('app');
        $app->setContainer($appContainer);

        return $app;
    }


    public function __construct(
        protected Response       $response,
        protected RequestHandler $handler,
    )
    {
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
                    $this->getContainer()
                )
            );
        } catch (ApplicationException $e) {
            $response->createResponse($e->getMessage(), $e->getCode());
        }
        $response->send();
    }

    private static function getDefinition(): array
    {
        $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . self::$bootstrap;
        if (!file_exists($file)) {
            throw new CoreException('Couldn`t find bootstrap file: ' . $file);
        }
        return require $file;
    }

    private static function buildContainer(): ContainerInterface
    {
        $appDefinition = self::getDefinition();
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($appDefinition);
        return $containerBuilder->build();
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