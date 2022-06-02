<?php

use Decole\Hw18\Domain\Repository\BaseProductRepository;
use Decole\Hw18\Domain\Repository\InnerProductRepository;
use Decole\Hw18\Domain\Repository\RecipeRepository;
use Decole\Hw18\Domain\Service\BaseProductFactory\BaseProductAbstractFactory;
use Decole\Hw18\Domain\Service\BaseProductListService;
use Decole\Hw18\Domain\Service\CompileService;
use Decole\Hw18\Domain\Service\InnerProductService;
use Decole\Hw18\Domain\Service\RecipeService;
use function DI\create;

return [
    BaseProductRepository::class => create(BaseProductRepository::class),
    BaseProductListService::class => static function () {
        $repository = new BaseProductRepository();

        return new BaseProductListService($repository);
    },

    InnerProductRepository::class => create(InnerProductRepository::class),
    InnerProductService::class => static function () {
        $repository = new InnerProductRepository();

        return new InnerProductService($repository);
    },

    RecipeRepository::class => create(RecipeRepository::class),
    RecipeService::class => static function () {
        $repository = new RecipeRepository();

        return new RecipeService($repository);
    },

    CompileService::class => static function () {
        $baseProductFactory = new BaseProductAbstractFactory();

        return new CompileService($baseProductFactory);
    }
];