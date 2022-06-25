<?php

namespace App\Service\CookingFood\Request;

use App\Service\CookingFood\Exception\ProductValidationException;
use Doctrine\DBAL\Types\Types;
use App\Service\CookingFood\Product\ProductEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRequest
{
    public function __construct(
        protected readonly ValidatorInterface $validator
    )
    {
    }

    /**
     * @throws ProductValidationException
     */
    public function validation(): void
    {
        $errorList = $this->validator->validate(
            $this->getValidationData(),
            $this->getAssertCollection(),
        );
        if (count($errorList) <= 0) {
            return;
        }
        $errors = [];
        foreach ($errorList as $error) {
            $key = trim($error->getPropertyPath(), '[]');
            $errors[$key] = $error->getMessage();
        }
        throw new ProductValidationException($errors);
    }

    protected function getAssertCollection(): Assert\Collection
    {
        return new Assert\Collection([
            'type' => [
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\Choice(ProductEnum::getValues()),
            ],
            'recipe_id' => [
                new Assert\NotBlank(),
                new Assert\NotNull(),
                new Assert\Type(Types::INTEGER),
            ],
        ]);
    }

    abstract public function getProductType(): string;

    abstract public function getRecipeId(): int;

    abstract protected function getValidationData(): array;
}