<?php

declare(strict_types=1);

namespace Mselyatin\Project5\classes;

use Mselyatin\Project5\classes\domain\ProcessingBracket;
use Mselyatin\Project5\interfaces\ApplicationInterface;
use Mselyatin\Project5\interfaces\RequestInterface;
use Mselyatin\Project5\interfaces\ResponseInterface;

/**
 * @Application
 * @\Mselyatin\Project5\classes\Application
 * @author Михаил Селятин
 */
class Application implements ApplicationInterface
{
    /**
     * @var ?ApplicationInterface
     */
    private static ?ApplicationInterface $app = null;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    private function __construct(
        RequestInterface $request,
        ResponseInterface $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ApplicationInterface
     */
    public static function create(
        RequestInterface $request,
        ResponseInterface $response
    ): ApplicationInterface {
        if (static::$app === null) {
            static::$app = new static($request, $response);
        }

        return static::$app;
    }

    public function run()
    {
        $brackets = $this->request->post('string');
        try {
            $handler = new ProcessingBracket($brackets);
            $handler->processing();

            $this->response->addItem('status', 'success');
            $this->response->addItem('message', 'String is valid');
            $this->response->setStatusCode(200);
        } catch (\Throwable $e) {
            $this->response->addItem('status', 'error');
            $this->response->addItem('message', 'String is not valid');
            $this->response->setStatusCode(400);
        }

        echo $this->response->buildResponse();
    }
}