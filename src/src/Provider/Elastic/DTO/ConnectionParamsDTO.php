<?php

namespace App\Provider\Elastic\DTO;

use App\Provider\Elastic\Service\Validator;

class ConnectionParamsDTO
{
    private string $host;
    private string $user;
    private string $password;
    private string $certPath;

    public function __construct(array $params)
    {
        $this->host = Validator::validateString($params['host']);
        $this->user = Validator::validateString($params['user']);
        $this->password = Validator::validateString($params['password']);
        $this->certPath = Validator::validateString($params['certPath']);
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getCertPath(): string
    {
        return $this->certPath;
    }
}