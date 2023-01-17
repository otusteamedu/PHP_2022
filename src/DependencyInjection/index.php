<?php

namespace Patterns\DependencyInjection;

require __DIR__ . '/../../vendor/autoload.php';

$db = new Database();
$repository = new UserRepository($db);
$repository->getUsers();
