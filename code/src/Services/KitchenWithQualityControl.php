<?php

namespace Ppro\Hw20\Services;

use Ppro\Hw20\Exceptions\KitchenException;
use Ppro\Hw20\Exceptions\QualityException;

/** Реализует приготовление продукта с контролем качества (Proxy)
 *
 */
class KitchenWithQualityControl extends Kitchen
{
    /**
     * @var int
     */
    private int $retryCount = 0;

    /**
     * @return void
     * @throws KitchenException
     */
    public function productCook()
    {
        $this->product->setStatus('The kitchen has started cooking'.PHP_EOL);
        $this->product->productCook($this->recipe->getProcess());
        try {
            $this->checkProductQuality();
        } catch (QualityException $e){
            //.. remake product or ...
            echo $e->getMessage();
            if($this->retryCount++ > 2)
                throw new KitchenException('The chef is not at his best today');
            $this->product->utilizeProduct();
            $this->productCook();
            return;
        }
        $this->product->setStatus('The kitchen has finished cooking'.PHP_EOL);
    }

    /**
     * @return void
     * @throws QualityException
     */
    private function checkProductQuality()
    {
        //...
        //проверка качества продукта
        $quality = rand(90,100) > 95;
        if($quality)
            throw new QualityException('Product quality must be up to 95'.PHP_EOL);
    }
}