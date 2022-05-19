<?php

declare(strict_types=1);

namespace App;

use PdoFactory\PdoFactory;

class DatabaseService
{
    public function run()
    {
        $params = ["first_name" => 'Test', "last_name" => 'Test', "email" => 'test@gmail.com', "id" => 1];

        $pdoFactory = new PdoFactory('database.ini');
        $pdo = $pdoFactory->createPDO('otus');
        $user = new UserTableGateway($pdo, $params);
        $user->update($params);
    }

}