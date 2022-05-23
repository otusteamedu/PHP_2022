<?php
declare(strict_types=1);


namespace Decole\Hw18\Application\Http;


use Decole\Hw18\Core\Dto\ServerErrorCode;
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
//        try {
//            $service = new InstallService();
//
//            $this->success($response, [
//                'status' => 'success',
//                'data' => $service->execute()
//            ]);
//        } catch (\Throwable $exception) {
//            $this->error($response, [$exception->getTrace()], ServerErrorCode::UNPROCESSABLE_ENTITY);
//        }
    }
}