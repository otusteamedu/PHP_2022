<?php
declare(strict_types = 1);

namespace Ppro\Hw20\Application;

use Ppro\Hw20\Application\Conf;
use Ppro\Hw20\Application\Register;
use Ppro\Hw20\Application\Request;

class ApplicationHelper
{
    /**
     * @var string
     */
    private $config = __DIR__ . "/../Config/options.ini";
    private $recipesConfig = __DIR__ . "/../Config/recipes.ini";

    private $reg;

    public function __construct()
    {
        $this->reg = Register::instance();
    }

    public function init()
    {
        $this->setupOptions();

        $request = Request::getInstance();
        $this->reg->setRequest($request);
    }

    /**  Обработка конфигурационных файлов приложения
     * @return void
     * @throws AppException
     */
    private function setupOptions()
    {
        if (! file_exists($this->config)) {
            throw new AppException("Could not find options file");
        }

        $options = parse_ini_file($this->config, true);
        $recipe = new Conf($options['recipe']);

        $this->reg->setRecipes($recipe);
        $product = new Conf($options['product']);
        $this->reg->setProducts($product);

        if (! file_exists($this->recipesConfig)) {
            throw new AppException("Could not find recipes file");
        }

        $recipesConfigArray = parse_ini_file($this->recipesConfig, true);
        $recipeSteps = new Conf($recipesConfigArray);
        $this->reg->setRecipeSteps($recipeSteps);

    }
}
