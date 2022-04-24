<?php


namespace Decole\Hw13\Controllers;


use Decole\Hw13\Core\Kernel;
use Decole\Hw13\Core\Services\AddEventService;
use Decole\Hw13\Core\Validators\EventsAddValidator;
use Klein\Request;
use Klein\Response;

class EventController extends AbstractController
{
    // пример ответа на простой запрос и энтрипоинт отвечающий, что бэкэнд жив.
    public function index(Request $request, Response $response)
    {
        try {
            $this->success($response, ['status' => 'ok']);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getTrace()]);
        }
    }

    // добавление события в стопку хранения
    public function add(Request $request, Response $response)
    {
        $events = json_decode($request->body(), true);
        $validator = new EventsAddValidator($events);

        if (!$validator->validate()) {
            $this->error($response, $validator->getErrors());

            return;
        }

        $service = new AddEventService();
        $dtoList = $service->createDtoList((array)$events);
        $service->addEvents($dtoList);

        $this->success($response, ['status' => 'success']);
    }

    public function find($request, $response)
    {
        Kernel::dump($request);
    }
}