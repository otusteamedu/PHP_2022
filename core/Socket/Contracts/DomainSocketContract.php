<?php
namespace Otus\Task11\Core\Socket\Contracts;

interface DomainSocketContract {
    public function getHost();
    public function initialize();
}