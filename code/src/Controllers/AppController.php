<?php
declare(strict_types=1);


namespace Decole\Hw15\Controllers;


use Decole\Hw15\Service\DeleteService;
use Decole\Hw15\Service\FindService;
use Decole\Hw15\Service\InstallService;
use Exception;
use Klein\Request;
use Klein\Response;

class AppController extends AbstractController
{
    public function index(Request $request, Response $response): void
    {
        try {
            $this->success($response, ['status' => 'ok']);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getTrace()]);
        }
    }

    public function create(Request $request, Response $response): void
    {
        try {
            $service = new InstallService();

            $this->success($response, [
                'status' => 'success',
                'data' => $service->execute()
            ]);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getTrace()]);
        }
    }

    public function find(Request $request, Response $response): void
    {
        try {
            $id = $request->params('id');

            if ($id === null) {
                throw new Exception('get me user id');
            }

            $service = new FindService();

            $this->success($response, [
                'status' => 'success',
                'data' => $service->execute((int)$id),
            ]);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getTrace()]);
        }
    }

    public function delete(Request $request, Response $response): void
    {
        try {
            $id = $request->params('id');

            if ($id === null) {
                throw new Exception('get me user id');
            }

            $user = (new FindService())->execute((int)$id);

            $service = new DeleteService();

            $this->success($response, [
                'status' => 'success',
                'deleted' => $service->execute($user)
            ]);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getTrace()]);
        }
    }
}