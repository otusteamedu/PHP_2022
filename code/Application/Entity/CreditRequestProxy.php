<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Application\Component\DataMapper\IdentityMap;
use App\Domain\Entity\CreditRequest;
use App\Domain\Entity\CreditRequestInterface;

class CreditRequestProxy implements CreditRequestInterface
{
    public function __construct(private readonly CreditRequest $request, private IdentityMap $identityMap)
    {
    }

    public function send(): void
    {
        $id = (int)$this->request->getPassportNumber();

        if (!$this->identityMap->hasId($id)) {

            $this->request->send();

            $this->identityMap->set($id, $this->request);
        }
    }
}