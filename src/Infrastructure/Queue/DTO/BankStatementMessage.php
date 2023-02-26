<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue\DTO;

class BankStatementMessage implements MessageInterface
{
    public function __construct(
        private string $email,
        private string $dateFrom,
        private string $dateTo
    ) {
    }

    public function serialize(): string
    {
        return serialize([
            'email' => $this->email,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo
        ]);
    }

    public static function fromSerialize(string $serialize): self
    {
        $data = unserialize($serialize);

        return new self(
            $data['email'],
            $data['dateFrom'],
            $data['dateTo']
        );
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @return string
     */
    public function getDateTo(): string
    {
        return $this->dateTo;
    }
}