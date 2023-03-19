<?php

namespace Ppro\Hw20\Application;

use Ppro\Hw20\Exceptions\AppException;
use Ppro\Hw20\Services\Order;

class App
{
    /**
     * @var Register|null
     */
    private ?Register $reg;

    /**
     *
     */
    public function __construct()
    {
        $this->reg = Register::instance();
    }

    /**
     * @return void
     * @throws AppException
     */
    public function run()
    {
        $this->init();
        $this->handleRequest();
    }

    /**
     * @return void
     */
    private function init()
    {
        $this->reg->getApplicationHelper()->init();
    }

    /**
     * @return void
     * @throws AppException
     */
    private function handleRequest()
    {
        $orderCmd = ($this->reg->getRequest())->getOrder();
        if(empty($orderCmd))
            throw new AppException('Command is empty');
        $orderSets = ($this->reg->getRequest())->getSets();
        $recipeClass = Register::instance()->getRecipe($orderCmd);
        $productClass = Register::instance()->getProduct($orderCmd);
        $recipeSteps = Register::instance()->getRecipeSteps()->getAll()[$orderCmd] ?? [];

        $order = new Order();
        $order->make($recipeClass, $productClass, $recipeSteps, $orderSets);
    }





}