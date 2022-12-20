<?php
namespace Otus\Task07\Core\Socket\Contracts;

interface DomainSocketContract {
    public function getHost();
    public function initialize();
}