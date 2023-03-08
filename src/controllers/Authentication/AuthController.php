<?php

declare(strict_types=1);

namespace Controllers\Authentication;

use Controllers\Controller;

final class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function login(): void
    {
        list(
            'username' => $username,
            'password' => $user_password
        ) = request()->body(safeData: true);

        $user = auth()->login([
            'username' => $username,
            'password' => $user_password
        ]); // returns null if failed

        if (empty($user['token'])) {
            response()->json(data: [
                'error' => 'Wrong combination email/password'
            ], code: 422);

            return;
        }

        response()->json(data: ['access_token' => $user['token']], code: 200);
    }
}
