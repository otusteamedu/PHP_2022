<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Event;
use App\Http\Response;
use App\Service\Event\EventManager;

class PostProcessor
{
    public function __construct(private readonly EventManager $em)
    {
    }

    public function process(): Response
    {
        if (isset($_POST['op'])) {
            switch ($_POST['op']) {

                case 'add':

                    $event = $this->addEvent();

                    if ($event !== false) {
                        return new Response("Event `$event` has been saved.");
                    }

                    break;

                case 'find':

                    $event = $this->findEvent();

                    if ($event === false) {
                        return new Response('Nothing was found.');
                    }

                    return new Response("Found: `$event`");

                case 'clear':

                    $this->em->clear();

                    return new Response('Storage has been cleaned.');
            }
        }

        return new Response('Bad Request', Response::HTTP_BAD_REQUEST, ['content-type' => 'text/html']);
    }

    private function addEvent(): false|Event
    {
        if (isset($_POST['name'], $_POST['priority'], $_POST['conditions'])
            && is_array($_POST['conditions'])) {

            $event = new Event();
            $event->setEventName($_POST['name']);
            $event->setPriority((int)$_POST['priority']);

            foreach ($_POST['conditions'] as $paramKey => $paramValue) {
                $event->addCondition($paramKey, $paramValue);
            }

            $this->em->save($event);

            return $event;
        }

        return false;
    }

    private function findEvent(): false|Event
    {
        if (isset($_POST['params']) && is_array($_POST['params'])) {
            return $this->em->findByParams($_POST['params']);
        }

        return false;
    }
}