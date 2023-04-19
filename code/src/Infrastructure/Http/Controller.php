<?php

declare(strict_types=1);

namespace Svatel\Code\Infrastructure\Http;

use Svatel\Code\Application\EventDriven\Publisher\Publisher;
use Svatel\Code\Application\EventDriven\Subscriber\ConcertExhibitionSubscriber;
use Svatel\Code\Application\EventDriven\Subscriber\ConcertSubscriber;
use Svatel\Code\Application\EventDriven\Subscriber\ExhibitionSubscriber;
use Svatel\Code\Application\EventDriven\Subscriber\SportSubscriber;
use Svatel\Code\Application\EventDriven\UseCases\CreateEventUseCase;
use Svatel\Code\Application\EventsFactory\ConcertExhibitionFactory;
use Svatel\Code\Application\EventsFactory\ConcertFactory;
use Svatel\Code\Application\EventsFactory\ExhibitionFactory;
use Svatel\Code\Application\EventsFactory\SportFactory;

final class Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addEvent(): Response
    {
        switch ($this->request['title']) {
            case 'sport':
                $factory = new SportFactory();
                $event = $factory->make($this->request['title'], $this->request['body']);
                break;
            case 'concert':
                $factory = new ConcertFactory();
                $event = $factory->make($this->request['title'], $this->request['body']);
                break;
            case 'exhibition':
                $factory = new ExhibitionFactory();
                $event = $factory->make($this->request['title'], $this->request['body']);
                break;
            case 'concert_exhibition':
                $factoryConcert = new ConcertFactory();
                $factory = new ConcertExhibitionFactory($factoryConcert);
                $event = $factory->make($this->request['title'], $this->request['body']);
                break;
            default:
                return new Response(500, 'Не валидный тип события');
        }
        $publisher = new Publisher();
        $useCase = new CreateEventUseCase($publisher, $event);
        $useCase->execute();

        return new Response(200, 'Событие успешно создано');
    }

    public function addSubscribe(): Response
    {
        switch ($this->request['title']) {
            case 'sport':
                $subscriber = new SportSubscriber($this->request['user_id']);
                break;
            case 'concert':
                $subscriber = new ConcertSubscriber($this->request['user_id']);
                break;
            case 'exhibition':
                $subscriber = new ExhibitionSubscriber($this->request['user_id']);
                break;
            case 'concert_exhibition':
                $subscriber = new ConcertExhibitionSubscriber($this->request['user_id']);
                break;
            default:
                return new Response(500, 'Не валидный тип подписки');
        }
        $publisher = new Publisher();
        $publisher->subscribe($subscriber);

        return new Response(200, 'Подписка успешно создана');
    }
}
