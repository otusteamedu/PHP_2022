<?php

declare(strict_types=1);

namespace App;

use PdoFactory\PdoFactory;

class DatabaseService
{
    public function run()
    {
        $pdoFactory = new PdoFactory('database.ini');
        $pdo = $pdoFactory->createPDO('otus');
        $user = new UserTableGateway($pdo);
        $user->getAll();
    }

}