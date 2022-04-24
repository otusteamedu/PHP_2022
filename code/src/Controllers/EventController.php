<?php


namespace Decole\Hw13\Controllers;


use Decole\Hw13\Core\Services\AddEventService;
use Decole\Hw13\Core\Services\FindEventService;
use Decole\Hw13\Core\Services\FlushEventService;
use Decole\Hw13\Core\Validators\EventsAddValidator;
use Decole\Hw13\Core\Validators\EventsFindValidator;
use JsonException;
use Klein\Request;
use Klein\Response;

class EventController extends AbstractController
{
    /**
     * Пример ответа на простой запрос и энтрипоинт отвечающий, что бэкэнд жив.
     *
     * @param Response $response
     * @return void
     * @throws JsonException
     */
    public function index(Response $response): void
    {
        try {
            $this->success($response, ['status' => 'ok']);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getTrace()]);
        }
    }

    /**
     * Добавление события в стопку хранения
     *
     * @throws JsonException
     */
    public function add(Request $request, Response $response): void
    {
        $events = $this->getBody($request);
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

    /**
     * Поиск по параметрам
     *
     * @param Request $request
     * @param Response $response
     * @return void
     * @throws JsonException
     */
    public function find(Request $request, Response $response): void
    {
        $query = $this->getBody($request);
        $validator = new EventsFindValidator($query);

        if (!$validator->validate()) {
            $this->error($response, $validator->getErrors());

            return;
        }

        $service = new FindEventService();

        $this->success($response, ['status' => $service->find($service->createDto($query))]);
    }

    /**
     * Очистка от всего
     *
     * @param Response $response
     * @return void
     * @throws JsonException
     */
    public function flush(Response $response): void
    {
        (new FlushEventService())->flushAll();

        $this->success($response, ['status' => 'success']);
    }

    /**
     * @throws JsonException
     */
    private function getBody(Request $request): array
    {
        return json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
    }
}