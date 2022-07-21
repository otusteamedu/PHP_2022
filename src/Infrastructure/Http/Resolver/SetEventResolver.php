<?php

namespace App\Infrastructure\Http\Resolver;

use App\Application\DTO\GetEventDTO;
use App\Application\DTO\SetEventDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class SetEventResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        new Assert\Collection([
            new Assert\Collection(
                fields: [
                    'priority' => new Assert\Positive,
                    'event' => new Assert\Required,
                    'conditions' => new Assert\Collection(
                        fields: [],
                        allowExtraFields: true,
                    ),
                ],
                allowExtraFields: true,
            ),
        ]);

        return (bool)$request->request->all();
    }


    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield new SetEventDTO($request->request->all());
    }
}
