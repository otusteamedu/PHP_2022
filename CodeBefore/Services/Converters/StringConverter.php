<?php

declare(strict_types=1);

namespace Src\Services\Converters;

final class StringConverter
{
    private array $emails;

    /**
     * @param array $emails
     */
    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->getAllEmailsLikeString();
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    private function getAllEmailsLikeString(): string
    {
        $tmp_arr = [];

        foreach ($this->emails as $email => $errors) {
            $tmp_arr[] = 'email [' . $email . '] not valid';
        }

        return implode(separator: ', ', array: $tmp_arr);
    }
}
