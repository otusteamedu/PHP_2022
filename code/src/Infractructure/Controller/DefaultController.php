<?php

namespace App\Infractructure\Controller;

use App\Application\Strategy\ContextStrategy;
use App\Application\Strategy\DrinkStrategy;
use App\Application\Strategy\FastFoodStrategy;
use App\Infractructure\Request\ClientRequest;
use App\Infractructure\Request\RecipeRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {

        $drinkStrategy = new DrinkStrategy();
        $fastFoodStrategy = new FastFoodStrategy();
        $coffee = $drinkStrategy->makeCoffee(new ClientRequest());
        $burger = $fastFoodStrategy->makeBurger(new RecipeRequest());
        $context = new ContextStrategy();
        $context->addToOrder($burger);
        $context->addToOrder($coffee);
        $context->execute();
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
