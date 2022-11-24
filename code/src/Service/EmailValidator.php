<?php


namespace Study\EmailValidator\Service;


class EmailValidator
{
    public function validate(array $emails)
    {
        $validEmailNames = array_filter( $emails, function ($email) {
            $email  = mb_strtolower(trim($email));
            return $this->checkEmailName( $email );
        } );
        $validEmails = array_filter( $validEmailNames, function ($email) {
            return $this->checkMXRecords( $email );
        } );
        return $validEmails;

    }

    public function checkEmailName($email)
    {
        if (empty( $email )) {
            return false;
        }
        if (!preg_match( "/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email )) {
            return false;
        }
        return true;
    }

    public function checkMXRecords($email): bool
    {
        $domain = $this->getDomain( $email );
        return getmxrr( $domain, $hosts );

    }

    private function getDomain($email)
    {
        return substr( $email, strpos( $email, '@' ) + 1 );
    }

}