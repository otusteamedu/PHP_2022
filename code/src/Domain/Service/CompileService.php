<?php


namespace Decole\Hw18\Domain\Service;


use Decole\Hw18\Domain\Service\BaseProductFactory\BaseProductAbstractFactory;

class CompileService
{
    public function __construct(private BaseProductAbstractFactory $baseProductAbstractFactory)
    {
    }

    public function collect(array $params)
    {
        $baseProduct = $params['baseProduct'];
        $recipe = $params['recipe'];
        $innerProducts = $params['inner_product'];

        $baseProductConcrete = $this->baseProductAbstractFactory->prepareBaseProduct($baseProduct);
        var_dump($baseProductConcrete);
        exit();
    }
}