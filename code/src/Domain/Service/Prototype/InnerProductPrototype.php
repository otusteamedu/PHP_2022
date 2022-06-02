<?php


namespace Decole\Hw18\Domain\Service\Prototype;


class InnerProductPrototype implements InnerProductPrototypeInterface
{
    public string $name;
    public string $type;
    public int $amount;
    public string $amountType;

    public function __clone()
    {
        $this->name = $this->name;
        $this->type = $this->type;
        $this->amountType = $this->amountType;
        $this->amount = $this->amount;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getAmountType(): string
    {
        return $this->amountType;
    }
}