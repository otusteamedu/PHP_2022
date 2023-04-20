<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

final class ConcertExhibitionFactory implements EventFactoryInterface
{
    private ConcertFactory $concertFactory;

    public function __construct(ConcertFactory $concertFactory)
    {
        $this->concertFactory = $concertFactory;
    }

    public function make(string $title, array $body): AbstractEvent
    {
        $box = new ConcertExhibition($title, $body);
        $concert = $this->concertFactory->make($body['concert_name'], $body['concert_info']);
        $box->add($concert);

        return $box;
    }
}
