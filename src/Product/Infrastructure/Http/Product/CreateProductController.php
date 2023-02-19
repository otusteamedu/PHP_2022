<?php

namespace Otus\Task13\Product\Infrastructure\Http\Product;

use Exception;
use Otus\Task13\Core\Http\Contract\HttpRequestInterface;
use Otus\Task13\Product\Application\Contract\CreateProductUseCaseInterface;
use Otus\Task13\Product\Application\Dto\Request\CreateProductRequestDto;
use Otus\Task13\Product\Domain\Exceptions\DomainErrorValidationException;

class CreateProductController
{

    public function __construct(
        private readonly HttpRequestInterface          $request,
        private readonly CreateProductUseCaseInterface $createProductUseCase,
    )
    {
    }

    public function __invoke()
    {
        try {
            $createProductResponseDto = $this->createProductUseCase->create(
                new CreateProductRequestDto(
                    name: $this->request->getPost()->get('name') ?: 'test',
                    description: $this->request->getPost()->get('name') ?: 'test',
                )
            );
        } catch (DomainErrorValidationException $exception) {
            var_dump('DomainErrorValidationException: ' . $exception->getMessage());

        } catch (Exception $exception) {
            var_dump('Exception: ' . $exception->getMessage());
        }


    }

}