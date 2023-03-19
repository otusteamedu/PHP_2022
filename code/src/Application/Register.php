<?php

namespace Ppro\Hw20\Application;

use Ppro\Hw20\Application\ApplicationHelper;
use Ppro\Hw20\Exceptions\AppException;

/** Класс для работы с реестром параметров приложения
 *
 */
class Register
{
    private static $instance = null;
    private Request $request;
    private Conf $recipe;
    private Conf $product;
    private Conf $recipeSteps;
    private $applicationHelper;
    private function __construct()
    {
    }

    public static function instance(): self
    {
        if(is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function getApplicationHelper(): ApplicationHelper
    {
        if (is_null($this->applicationHelper)) {
            $this->applicationHelper = new ApplicationHelper();
        }

        return $this->applicationHelper;
    }

    public static function reset(): void
    {
        self::$instance = null;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Conf $recipe
     */
    public function setRecipes(Conf $recipe): void
    {
        $this->recipe = $recipe;
    }

    /**
     * @return Conf
     */
    public function getRecipes(): Conf
    {
        return $this->recipe;
    }
    public function getRecipe(string $name): string
    {
        return $this->recipe->get($name) ?? '';
    }

    /**
     * @param Conf $recipe
     */
    public function setProducts(Conf $product): void
    {
        $this->product = $product;
    }

    /**
     * @return Conf
     */
    public function getProducts(): Conf
    {
        return $this->product;
    }
    public function getProduct(string $name): string
    {
        return $this->product->get($name) ?? '';
    }

    public function setRecipeSteps(Conf $recipeSteps)
    {
        $this->recipeSteps = $recipeSteps;
    }
    public function getRecipeSteps(): Conf
    {
        return $this->recipeSteps;
    }

}