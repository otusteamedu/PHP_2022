<?php

namespace app\Application\Service;

use app\Application\Dto\CreateOrderRequestDTO;
use app\Domain\CookBuilder\CookBuilder;
use app\Domain\Model\Ingredient\AbstractIngredient;
use app\Domain\Model\Ingredient\Bread;
use app\Domain\Model\Ingredient\Bun;
use app\Domain\Model\Ingredient\Cutlet;
use app\Domain\Model\Ingredient\Onion;
use app\Domain\Model\Ingredient\Pepper;
use app\Domain\Model\Ingredient\Salad;
use app\Domain\Model\Ingredient\Sausage;
use app\Domain\Model\Order\AbstractOrder;
use app\Domain\Model\Order\RestaurantOrder;
use app\Domain\Model\Product\ProductInterface;
use app\Domain\ProductFactory\RestaurantProductFactory;
use app\Domain\ValueObject\OrderItem;

class OrderService implements OrderServiceInterface {

    public function createOrder(CreateOrderRequestDTO $request): AbstractOrder {
        $order = new RestaurantOrder();
        foreach ($request->getItems() as $DTOItem) {
            $product = $this->getProductByName($DTOItem->productName);
            $item = new OrderItem();
            $item->setProduct($product);
            $item->setQuantity($DTOItem->quantity);
            foreach ($DTOItem->extraIngredients as $ingredient){
                $product->addIngredient($this->getIngredientByName($ingredient));
            }
            $order->addItem($item);
        }

        return $order;
    }

    public function cookOrder(AbstractOrder $order): string
    {
        $result = '';
        foreach ($order->getItems() as $item) {
            $builder = new CookBuilder($item->getProduct());
            $result .= $builder->prepareTools();
            $result .= $builder->addIngredients();
            $result .= $builder->cook();
        }
        return $result;
    }

    private function getProductByName(string $name): ProductInterface {
        $factory = new RestaurantProductFactory();
        switch ($name) {
            case 'Burger':
                $product = $factory->createBaseBurger();
                break;
            case 'Sandwich':
                $product = $factory->createBaseSandwich();
                break;
            case 'Hotdog':
                $product = $factory->createBaseHotdog();
                break;
            default:
                throw new \BadMethodCallException('Неправильный запрос');
        }

        return $product;
    }

    private function getIngredientByName(string $name): AbstractIngredient {
        switch ($name) {
            case 'Bread': return new Bread();
            case 'Bun': return new Bun();
            case 'Cutlet': return new Cutlet();
            case 'Sausage': return new Sausage();
            case 'Salad': return new Salad();
            case 'Onion': return new Onion();
            case 'Pepper': return new Pepper();
            default:
                throw new \BadMethodCallException('Неправильный запрос');
        }
    }
}
