<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Domain\Email;

class Email
{
    private EmailName $name;
    private EmailDomain $domain;

    /**
     * @param EmailName $name
     * @param EmailDomain $domain
     */
    public function __construct(EmailName $name, EmailDomain $domain)
    {
    }

    /**
     * @return EmailName
     */
    public function getName(): EmailName
    {
        return $this->name;
    }

    /**
     * @param EmailName $name
     * @return Email
     */
    public function setName(EmailName $name): Email
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return EmailDomain
     */
    public function getDomain(): EmailDomain
    {
        return $this->domain;
    }

    /**
     * @param EmailDomain $domain
     * @return Email
     */
    public function setDomain(EmailDomain $domain): Email
    {
        $this->domain = $domain;
        return $this;
    }
}