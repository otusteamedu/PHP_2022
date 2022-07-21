<?php

namespace App\Infrastructure\Http\Resolver;

use App\Application\DTO\GetEventDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class GetEventResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        new Assert\Collection([
            'params' => new Assert\Collection(
                fields: [],
                allowExtraFields: true,
            ),
        ]);

        return (bool)$request->get('params');
    }


    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield new GetEventDTO($request->get('params'));
    }
}
