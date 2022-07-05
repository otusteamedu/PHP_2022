<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Event;
use App\Http\Response;
use App\Service\Event\EventManager;

class PostProcessor
{
    public function __construct(private EventManager $em)
    {
    }

    public function process(): Response
    {
        if (isset($_POST['op'])) {

            switch ($_POST['op']) {

                case 'add':

                    if (isset($_POST['name'], $_POST['priority'], $_POST['conditions'])) {

                        $event = new Event();
                        $event->setEventName($_POST['name']);
                        $event->setPriority($_POST['priority']);

                        foreach ($_POST['conditions'] as $paramKey => $paramValue) {
                            $event->addCondition($paramKey, $paramValue);
                        }

                        $this->em->save($event);

                        return new Response('Event has been saved!');
                    }

                    break;

                case 'find':

                    if (isset($_POST['params']) && is_array($_POST['params'])) {

                        $event = $this->em->findByParams($_POST['params']);

                        return new Response(json_encode($event));
                    }

                    break;

                case 'clear':

                    $this->em->clear();

                    return new Response('Storage has been cleaned!');
            }
        }

        return new Response('Bad Request', Response::HTTP_BAD_REQUEST, ['content-type' => 'text/html']);
    }
}