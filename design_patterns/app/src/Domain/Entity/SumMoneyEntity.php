<?php

namespace Patterns\App\Domain\Entity;

class SumMoneyEntity implements Entity
{
    public function __construct(
        private int $id,
        private int $fifty_banknote_count,
        private int $hundred_banknote_count,
        private int $five_hundred_banknote_count,
        private int $thousand_banknote_count,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFiftyBanknoteCount(): int
    {
        return $this->fifty_banknote_count;
    }

    public function getHundredBanknoteCount(): int
    {
        return $this->hundred_banknote_count;
    }

    public function getFiveHundredBanknoteCount(): int
    {
        return $this->five_hundred_banknote_count;
    }

    public function getThousandBanknoteCount(): int
    {
        return $this->thousand_banknote_count;
    }

    public function toArray(): array
    {
       return [
           'id' => $this->id,
           'fifty_banknote_count' => $this->fifty_banknote_count,
           'hundred_banknote_count' => $this->hundred_banknote_count,
           'five_hundred_banknote_count' => $this->five_hundred_banknote_count,
           'thousand_banknote_count' => $this->thousand_banknote_count,
       ];
    }
}