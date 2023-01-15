<?php

namespace Otus\Task11\App\Controllers;

use Otus\Task11\App\Controller;
use Otus\Task11\App\Services\Event\Event;
use Otus\Task11\App\Services\Event\EventManager;


class HomeController extends Controller
{
    public function index(): void
    {
          $eventManager = EventManager::driver('redis');
          $eventManager->send(new Event('events', ['param1' => rand(1,2), 'param2' => rand(1,2)], rand(1, 100)) );

          $result = $eventManager->get(['param1' => rand(1,2), 'param2' => rand(1,2)]);
         //$eventManager->clean();
    }
}