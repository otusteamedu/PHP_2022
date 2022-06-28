<?php

namespace App\Controller;

use App\Listener\StatusCookingListener;
use App\Service\CookingFood\CookingService;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\CookingFood\Exception\RecipeNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\CookingFood\Exception\ProductValidationException;

#[Route(path: 'api/product')]
class CreateFoodController extends AbstractController
{
    public function __invoke(
        CookingService $cookingService,
    ): JsonResponse
    {
        try {
            $cookingService->addStartCookingListener(new StatusCookingListener);
            $cookingService->addEndCookingListener(new StatusCookingListener);
            $cookingService->makeProduct();
        } catch (RecipeNotFoundException $e) {
            return new JsonResponse([
                'errors' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        } catch (ProductValidationException $e) {
            return new JsonResponse([
                'errors' => $e->getErrors(),
                'code' => $e->getCode(),
            ], $e->getCode());
        }
        return new JsonResponse([
            'code' => Response::HTTP_CREATED,
            'message' => 'the product has been created',
        ], Response::HTTP_CREATED);
    }
}