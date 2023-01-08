<?php
namespace Otus\Task10\Core\Socket\Contracts;

interface DomainSocketContract {
    public function getHost();
    public function initialize();
}