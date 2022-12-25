<?php
namespace Otus\Task06\Core\Socket\Contracts;

interface DomainSocketContract {
    public function getHost();
    public function initialize();
}