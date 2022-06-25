<?php

namespace App\Service\CookingFood\Request;

use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HttpRequest extends AbstractRequest
{
    private readonly Request $request;
    private readonly InputBag $inputBag;

    public function __construct(
        RequestStack       $request,
        ValidatorInterface $validator
    )
    {
        parent::__construct($validator);
        $this->request = $request->getCurrentRequest();
        $this->inputBag = $this->request->request;
    }

    public function getProductType(): string
    {
        return $this->inputBag->get('type');
    }

    public function getRecipeId(): int
    {
        return $this->inputBag->getInt('recipe_id');
    }

    protected function getValidationData(): array
    {
        $data = $this->inputBag->all();
        if (isset($data['recipe_id']) && is_numeric($data['recipe_id'])) {
            $data['recipe_id'] = (int)$data['recipe_id'];
        }
        return $data;
    }
}