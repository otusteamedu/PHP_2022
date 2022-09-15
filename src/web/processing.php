<?php

declare(strict_types=1);

require("../../vendor/autoload.php");

use Mselyatin\Patterns\infrastructure\mappers\TypeProductToStrategyMapper;
use Mselyatin\Patterns\infrastructure\mappers\StringIdToCompositionMapper;
use Mselyatin\Patterns\Application;
use Mselyatin\Patterns\application\interfaces\services\FastFoodServiceInterface;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;
use Mselyatin\Patterns\domain\constants\ReadinessStatusConstants;

$configs = require_once('../../config/configs.php') ?? [];

try {
    $application = new \Mselyatin\Patterns\Application();
    $application->run($configs);

    $request = $application->request;

    if ($request->get('order_btn')) {
        $typeProduct = $request->get('product_id');
        $composition = $request->get('composition');

        if (!$typeProduct || empty($composition)) {
            throw new InvalidArgumentException('Тип продукта или ингридиенты не заполнены');
        }

        /**
         * Получаем стратегию, что готовить
         */
        $typeProduct = (int)$typeProduct;
        $strategyClass = TypeProductToStrategyMapper::map($typeProduct);

        $strategy = Application::$container->get($strategyClass);
        $serviceFoodClass = Application::$container->get(FastFoodServiceInterface::class);

        /** @var FastFoodServiceInterface $service */
        $service = new $serviceFoodClass($strategy);

        /**
         * Создаем продукт с стандртным содержимым
         */
        $food = $service->createFood(
            new ReadinessStatusValue(ReadinessStatusConstants::WAIT)
        );

        /**
         * Используем декораторы, чтобы дополнить состав выбранный юзером в форме
         */
        foreach ($composition as $type) {
            $decoratorClass = StringIdToCompositionMapper::map($type);
            if ($decoratorClass && class_exists($decoratorClass)) {
                $food = new $decoratorClass($food);
            }
        }

        echo '<br>';
        echo 'Тип продукта: ' . $food->getType()->getValue() . ' <br><br>';
        echo 'Выбранный состав: ';
        echo '<pre>';

        /**
         * Парсим состав и выводим их названия
         */

        $items = [];
        $item = $food->getComposition()->current();
        do {
            $items[] = $item->getName();
        } while ($item = $food->getComposition()->next());

        var_dump($items);
    }

} catch (\Throwable $e) {
    var_dump(
        'Unknown error. Retry later. ' . $e->getMessage()
    );
    die();
}