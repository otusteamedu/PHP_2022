<?php

namespace App;

use TinkoffInvest\Client;

class Index
{
    public function __construct()
    {
        $client = new Client('token');
        $client->setAccountId('acc_id');
        var_dump($client->user()->accounts());
    }
}
