<?php

namespace Otus\App\Application\Entity\Producer;

class BankMessage
{
    private string $email;
    private \DateTime $date_start;
    private \DateTime $date_end;

    /**
     * @param string $email
     * @param \DateTime $date_start
     * @param \DateTime $date_end
     */
    public function __construct(string $email, \DateTime $date_start, \DateTime $date_end) {
        $this->email = $email;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->date_start;
    }

    /**
     * @return \DateTime
     */
    public function getDateStartStr(): string
    {
        return $this->date_start->format("Y-m-d");
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime
    {
        return $this->date_end;
    }

    /**
     * @return \DateTime
     */
    public function getDateEndStr(): string
    {
        return $this->date_end->format("Y-m-d");
    }
}
