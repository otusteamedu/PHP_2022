<?php

declare(strict_types=1);


namespace Mapaxa\BalancerApp\Controller;


class PageNotFoundController
{
    public function index(): void
    {
        require_once ('src/View/common/404.php');
    }
}