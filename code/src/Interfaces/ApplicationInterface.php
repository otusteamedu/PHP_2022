<?php

declare(strict_types=1);

namespace Mselyatin\Project5\interfaces;

/**
 * @ApplicationInterface
 * @\Mselyatin\Project5\interfaces\ApplicationInterface
 * @author Михаил Селятин
 */
interface ApplicationInterface
{
    /**
     * @return ApplicationInterface
     */
    public static function create(RequestInterface $request, ResponseInterface $response): ApplicationInterface;

    /**
     * @return mixed
     */
    public function run();
}