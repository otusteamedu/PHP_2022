<?php

namespace App\Http\Controllers;

use App\Application\EventStorage\Contracts\EventStorageInterface;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ApiController extends Controller
{
    public function root()
    {
        return response()->json(['message' => 'ok']);
    }

    public function add(Request $httpRequest, EventStorageInterface $eventStorage)
    {
        $eventName = $httpRequest->json()->get('eventName');
        if (!is_string($eventName) || ($eventName === '')) {
            throw new InvalidArgumentException('eventName: expected not empty string.');
        }

        $priority = $httpRequest->json()->get('priority');
        if (!is_int($priority) || ($priority < 1)) {
            throw new InvalidArgumentException('priority: expected integer value grater than zero.');
        }

        $params = $httpRequest->json()->get('params');
        if (!is_array($params) || ($params === [])) {
            throw new Exception('params: expected object');
        }

        $eventStorage->add($eventName, $priority, $params);

        return response()->json(['message' => 'ok']);
    }

    public function find(Request $httpRequest, EventStorageInterface $eventStorage)
    {
        $params = $httpRequest->json()->get('params');
        if (!is_array($params) || ($params === [])) {
            throw new Exception('params: expected object');
        }

        return response()->json(['event' => $eventStorage->findEvent($params)]);
    }

    public function clear(EventStorageInterface $eventStorage)
    {
        $eventStorage->clearAll();
        return response()->json(['message' => 'ok']);
    }
}
