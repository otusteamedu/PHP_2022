<?php declare(strict_types = 1);

$injector = new \Auryn\Injector;
//request
$injector->alias('Queen\App\Core\Http\HttpRequest', 'Queen\App\Core\Http\HttpRequest');
$injector->share('Queen\App\Core\Http\HttpRequest');
$injector->define('Queen\App\Core\Http\HttpRequest', [
    ':get'     => $_GET,
    ':post'    => $_POST,
    ':server'  => $_SERVER
]);

//response
$injector->alias('Queen\App\Core\Http\HttpResponse', 'Queen\App\Core\Http\HttpResponse');
$injector->share('Queen\App\Core\Http\HttpResponse');

//render
$injector->alias('Queen\App\Core\Template\Renderer', 'Queen\App\Core\Template\MustacheRenderer');
$injector->define('Mustache_Engine', [
    ':options' => [
        'loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/views', [
            'extension' => '.php',
        ]),
    ],
]);

return $injector;
