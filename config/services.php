<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Otus\Task14\Client;
use Otus\Task14\Core\Config\Config;
use Otus\Task14\Core\Config\Contracts\ConfigInterface;
use Otus\Task14\Core\Http\Contract\HttpRequestInterface;
use Otus\Task14\Core\Http\HttpRequest;


return static function (ContainerConfigurator $containerConfigurator) {

    $services = $containerConfigurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();


    $services->set(HttpRequestInterface::class, HttpRequest::class)->args([$_POST]);
    $services->set(ConfigInterface::class, Config::class)->args([__DIR__ . '/app.php']);
    $services->set(Client::class, Client::class);

    //$services->load('Otus\\Task14\\', '../src/');

};