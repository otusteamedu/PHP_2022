<?php

declare(strict_types=1);

namespace App\Domain\Repository\Entities;

final class Ticket
{
    private const FAKE_DB_ID = 0;

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $date_of_sale;

    /**
     * @var string
     */
    private string $time_of_sale;

    /**
     * @var int
     */
    private int $customer_id;

    /**
     * @var int
     */
    private int $schedule_id;

    /**
     * @var string
     */
    private string $total_price;

    /**
     * @var string
     */
    private string $movie_name;

    /**
     * @param int $id
     * @param string $date_of_sale
     * @param string $time_of_sale
     * @param int $customer_id
     * @param int $schedule_id
     * @param string $total_price
     * @param string $movie_name
     */
    public function __construct(
        int $id,
        string $date_of_sale= '',
        string $time_of_sale = '',
        int $customer_id = self::FAKE_DB_ID,
        int $schedule_id = self::FAKE_DB_ID,
        string $total_price = '',
        string $movie_name = '',
    ) {
        $this->id = $id;
        $this->date_of_sale = $date_of_sale;
        $this->time_of_sale = $time_of_sale;
        $this->customer_id = $customer_id;
        $this->schedule_id = $schedule_id;
        $this->total_price = $total_price;
        $this->movie_name = $movie_name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateOfSale(): string
    {
        return $this->date_of_sale;
    }

    /**
     * @param string $date_of_sale
     * @return $this
     */
    public function setDateOfSale(string $date_of_sale): self
    {
        $this->date_of_sale = $date_of_sale;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimeOfSale(): string
    {
        return $this->time_of_sale;
    }

    /**
     * @param string $time_of_sale
     * @return $this
     */
    public function setTimeOfSale(string $time_of_sale): self
    {
        $this->time_of_sale = $time_of_sale;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    /**
     * @param int $customer_id
     * @return $this
     */
    public function setCustomerId(int $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getScheduleId(): int
    {
        return $this->schedule_id;
    }

    /**
     * @param int $schedule_id
     * @return $this
     */
    public function setScheduleId(int $schedule_id): self
    {
        $this->schedule_id = $schedule_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTotalPrice(): string
    {
        return $this->total_price;
    }

    /**
     * @param string $total_price
     * @return $this
     */
    public function setTotalPrice(string $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    /**
     * @return string
     */
    public function getMovieName(): string
    {
        return $this->movie_name;
    }

    /**
     * @param string $movie_name
     * @return $this
     */
    public function setMovieName(string $movie_name): self
    {
        $this->movie_name = $movie_name;

        return $this;
    }
}
