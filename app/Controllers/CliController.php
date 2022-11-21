<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Mechanisms\DatabaseConnector;
use App\Domain\Repository\Entities\Ticket;
use App\Domain\Repository\Mappers\TicketMapper;

final class CliController
{
    private TicketMapper $mapper;

    public function __construct()
    {
        $this->mapper = new TicketMapper(db_connector: new DatabaseConnector());
    }

    /**
     * @param int $ticket_id
     * @return void
     */
    public function find(int $ticket_id): void
    {
        $result = $this->mapper->findById(id: $ticket_id);

        $output_line = 'id: ' . $result->getId() . '; '
            . 'date_of_sale: ' . $result->getDateOfSale() . '; '
            . 'time_of_sale: ' . $result->getTimeOfSale() . '; '
            . 'customer_id: ' . $result->getCustomerId() . '; '
            . 'schedule_id: ' . $result->getScheduleId() . '; '
            . 'total_price: ' . $result->getTotalPrice() . '; '
            . 'movie_name: ' . $result->getMovieName();

        fwrite(stream: STDOUT ,data: $output_line . PHP_EOL);
    }

    /**
     * @return void
     */
    public function findAll(): void
    {
        $results = $this->mapper->getAll();

        $output_line = '';

        $index = 0;
        foreach ($results as $result) {
            ++$index;

            $output_line .= '#' . $index . ': '
                . 'id: ' . $result->getId() . '; '
                . 'date_of_sale: ' . $result->getDateOfSale() . '; '
                . 'time_of_sale: ' . $result->getTimeOfSale() . '; '
                . 'customer_id: ' . $result->getCustomerId() . '; '
                . 'schedule_id: ' . $result->getScheduleId() . '; '
                . 'total_price: ' . $result->getTotalPrice() . '; '
                . 'movie_name: ' . $result->getMovieName() . PHP_EOL;
        }

        fwrite(stream: STDOUT ,data: $output_line . PHP_EOL);
    }

    /**
     * @param array $raw_data
     * @return void
     * @throws \Exception
     */
    public function insert(array $raw_data): void
    {
        $new_ticket = new Ticket();

        $new_ticket->setDateOfSale(date_of_sale: $raw_data['date_of_sale']);
        $new_ticket->setTimeOfSale(time_of_sale: $raw_data['time_of_sale']);
        $new_ticket->setCustomerId(customer_id: $raw_data['customer_id']);
        $new_ticket->setScheduleId(schedule_id: $raw_data['schedule_id']);
        $new_ticket->setTotalPrice(total_price: $raw_data['total_price']);
        $new_ticket->setMovieName(movie_name: $raw_data['movie_name']);

        $this->mapper->insert(ticket: $new_ticket);

        fwrite(stream: STDOUT ,data: 'Данные успешно добавлены' . PHP_EOL);
    }

    /**
     * @param array $raw_data
     * @return void
     * @throws \Exception
     */
    public function update(array $raw_data): void
    {
        $ticket = $this->mapper->findById(id: $raw_data['id']);

        $ticket->setDateOfSale(date_of_sale: $raw_data['date_of_sale']);
        $ticket->setTimeOfSale(time_of_sale: $raw_data['time_of_sale']);
        $ticket->setCustomerId(customer_id: $raw_data['customer_id']);
        $ticket->setScheduleId(schedule_id: $raw_data['schedule_id']);
        $ticket->setTotalPrice(total_price: $raw_data['total_price']);
        $ticket->setMovieName(movie_name: $raw_data['movie_name']);

        $this->mapper->update(ticket: $ticket);

        fwrite(stream: STDOUT ,data: 'Данные успешно обновлены' . PHP_EOL);
    }

    /**
     * @param int $ticket_id
     * @return void
     * @throws \Exception
     */
    public function delete(int $ticket_id): void
    {
        $existed_ticket = $this->mapper->findById(id: $ticket_id);

        $this->mapper->delete(ticket: $existed_ticket);

        fwrite(stream: STDOUT ,data: 'Данные успешно удалены' . PHP_EOL);
    }
}
