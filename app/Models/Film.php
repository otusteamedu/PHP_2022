<?php

namespace App\Models;

use DateTime;

class Film implements HasIdInterface
{
    private int $id;
    private string $title;
    private string $description;
    private ?string $poster;
    private DateTime $premierDate;


    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param DateTime $premierDate
     * @param string|null $poster
     */
    public function __construct(int $id, string $title, string $description, DateTime $premierDate, string $poster = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->poster = $poster;
        $this->premierDate = $premierDate;
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
     *
     * @return Film
     */
    public function setId(int $id): Film
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * @param string $title
     *
     * @return Film
     */
    public function setTitle(string $title): Film
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * @param string $description
     *
     * @return Film
     */
    public function setDescription(string $description): Film
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return string
     */
    public function getPoster(): string
    {
        return $this->poster;
    }


    /**
     * @param string $poster
     *
     * @return Film
     */
    public function setPoster(string $poster): Film
    {
        $this->poster = $poster;

        return $this;
    }


    /**
     * @return string
     */
    public function getPremierDate(): string
    {
        return $this->premierDate->format('Y-m-d');
    }


    /**
     * @param DateTime $premierDate
     *
     * @return Film
     */
    public function setPremierDate(DateTime $premierDate): Film
    {
        $this->premierDate = $premierDate;

        return $this;
    }

//
//    public function __toArray(): array
//    {
//        return [
//            'id' => $this->getId(),
//            'title' => $this->getTitle(),
//            ''
//        ];
//    }

}
