<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\Controller;

use Nikcrazy37\Hw14\Libs\BaseController;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\View;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\IngredientEnum;
use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order\OrderBurger;
use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order\OrderHotDog;
use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order\OrderSandwich;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\Notifier;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\QualityFood;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\BurgerFood;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\HotDogFood;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\SandwichFood;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\FoodRecipe;
use DI\Container;
use DI\ContainerBuilder;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\Model\OrderProcess;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\DTO\Ingredients;

class EateryController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->view = new View();
    }

    public function index()
    {
        $result = IngredientEnum::cases();

        $this->view->generate("order/index.php", $result);
    }

    public function create()
    {
        $food = $this->request->food;

        $ingredients = null;
        if ($this->request->exist("ingredients")) {
            $ingredients = new Ingredients(
                array_map(static fn($ingredient) => IngredientEnum::from($ingredient), $this->request->ingredients)
            );
        }

        /*try {
            $container = new Container();

            $order = $container->get(OrderBurger::class)
                ->setNext($container->get(OrderHotDog::class))
                ->setNext($container->get(OrderSandwich::class));
        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            echo "</pre>";
        }*/



        try {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->addDefinitions(__DIR__ . "/../definitions.php");
            $container = $containerBuilder->build();
            $orderProcess = $container->get(OrderProcess::class);

            $res = $orderProcess->addIngredients($ingredients)->start();

//            $order = $container->get(OrderBurger::class)
//                ->setNext($container->get(OrderHotDog::class))
//                ->setNext($container->get(OrderSandwich::class));
        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            echo "</pre>";
        }
        /*$order = new OrderBurger(
            new QualityFood(
                new BurgerFood(
                    new FoodRecipe($ingredients)
                )
            ),
            new Notifier(),
        );
        $order
            ->setNext(
                new OrderHotDog(
                    new QualityFood(
                        new HotDogFood(
                            new FoodRecipe($ingredients)
                        )
                    ),
                    new Notifier(),
                )
            )
            ->setNext(
                new OrderSandwich(
                    new QualityFood(
                        new SandwichFood(
                            new FoodRecipe($ingredients)
                        )
                    ),
                    new Notifier(),
                )
            );*/

        if ($res !== null) {
            $result["orderId"] = $res->getId()->getValue();
            $result["foodName"] = $res->getFood()->getName();
            $result["recipe"] = $res->getFood()->getRecipe();

            $this->view->generate("order/create.php", $result);
        }
    }
}