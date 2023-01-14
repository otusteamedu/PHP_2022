<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Restaurant\Application\HotDogFactory;
use App\Modules\Restaurant\Infrastructure\Enums\SauceEnum;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function index(): View
    {
        return view('welcome', ['message' => 'Добро пожаловать!']);
    }

    public function getHotDog(Request $request)
    {

        try {
            $sauce = $this->validate($request, [
                'sauce' => ['required', 'string', new Enum(SauceEnum::class)],
            ])['sauce'];

            $hotdog = (new HotDogFactory($sauce))->create();

            $response = [
                'message' => 'Готово!',
                'burger' => $hotdog
            ];
        } catch (Exception $exception) {
            $response = [
                'message' => $exception->getMessage(),
            ];
        }


        return view('welcome', $response);
    }
}
