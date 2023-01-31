<?php

declare(strict_types=1);

namespace Src\Sandwich\Infrastructure;

use Src\Sandwich\Application\Core\Core;
use Src\Sandwich\DTO\SandwichParametersDTO;
use Src\Sandwich\Domain\Contracts\BasicProduct;
use Src\Sandwich\Application\Proxy\CookingProcessProxy;

use function cli\{line, menu, prompt};

final class CliController
{
    /**
     * @var CookingProcessProxy
     */
    private CookingProcessProxy $cooking_process;

    public function __construct()
    {
        $application_core = new Core();

        $this->cooking_process = $application_core->start()->get(CookingProcessProxy::class);
    }

    /**
     * @return BasicProduct
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function startCooking(): BasicProduct
    {
        line(msg: 'Добро пожаловать! Что желаете?' . PHP_EOL);

        $sandwich_prototype_id = menu(
            items: [
                1 => 'Burger',
                2 => 'Sandwich',
                3 => 'Hot Dog',
            ],
            default: false,
            title: 'Ваш выбор'
        );

        $sandwich_prototypes = [
            1 => 'Burger',
            2 => 'Sandwich',
            3 => 'HotDog',
        ];

        line(msg: 'Что добавить?' . PHP_EOL);

        $sandwich_partials = [];
        $answer = 'y';

        while (in_array(needle: $answer, haystack: ['y', 'yes', 'д', 'да'])) {
            $sandwich_partials_id = menu(
                items: [
                    1 => 'Onion',
                    2 => 'Bacon',
                    3 => 'Tomato',
                ],
                default: false,
                title: 'Выш выбор: '
            );

            $sandwich_partials_map = [
                1 => 'Onion',
                2 => 'Bacon',
                3 => 'Tomato',
            ];

            $selected_ingredient = $sandwich_partials_map[$sandwich_partials_id];

            if (! empty($sandwich_partials[$selected_ingredient])) {
                $quantity_ingredients = $sandwich_partials[$selected_ingredient];

                $sandwich_partials[$selected_ingredient] = ++$quantity_ingredients;
            } else {
                $sandwich_partials[$selected_ingredient] = 1;
            }

            $answer = prompt(question: 'Добавить что-то еще?');
        }

        return $this->cooking_process->startCooking(
            sandwich_parameters_dto: new SandwichParametersDTO(
                sandwich_prototype: $sandwich_prototypes[$sandwich_prototype_id],
                sandwich_partials: $sandwich_partials
            )
        )->getResult();
    }
}
