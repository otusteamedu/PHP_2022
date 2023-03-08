<?php

declare(strict_types=1);

namespace Middleware\Authentication;

use Leaf\Middleware;

final class AuthControllerMiddleware extends Middleware
{
    /**
     * @return void
     */
    public function call(): void
    {
        if (
            request()->getPathInfo() === '/api/v1/login'
            && ! request()->typeIs(type: "POST")
        ) {
            response()->json(data: ['error' => 'Only POST method allowed'], code: 422);

            $input_data = request()->body();

            if (! isset($input_data['username']) || $input_data['username'] === '') {
                response()->json(data: ['error' => 'username not entered'], code: 422);
            }

            return;
        }

        $this->next();
    }
}
