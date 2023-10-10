<?php

declare(strict_types=1);

$builder = new DI\ContainerBuilder();

$builder->addDefinitions(require __DIR__ . '/dependences.php');

return $builder->build();
