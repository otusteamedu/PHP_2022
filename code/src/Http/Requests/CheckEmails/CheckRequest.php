<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Http\Requests\CheckEmails;

use Nsavelev\Hw5\Foundation\Request\BaseInputRequest;
use Nsavelev\Hw5\Foundation\Request\Interfaces\RequestInterface;
use Nsavelev\Hw5\Http\Requests\CheckEmails\Exceptions\MailIsNotStringException;

class CheckRequest extends BaseInputRequest implements RequestInterface
{
    /** @var array */
    private array $mails = array();

    public function __construct()
    {
        parent::__construct();

        $this->validate();
    }

    /**
     * @return array
     */
    public function getMails(): array
    {
        return $this->mails;
    }

    /**
     * @return void
     * @throws MailIsNotStringException
     */
    public function validate(): void
    {
        foreach ($this->mails as $mail) {
            if (!is_string($mail)) {
                throw new MailIsNotStringException('All the elements of `mails` attribute mast be a string.');
            }
        }
    }
}