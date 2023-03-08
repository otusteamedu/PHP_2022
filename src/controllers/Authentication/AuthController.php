<?php

declare(strict_types=1);

namespace Controllers\Authentication;

use Controllers\Controller;
use OpenApi\Annotations as OA;

final class AuthController extends Controller
{
    /**
     * @OA\Info(title="Otus homework 17 API", version="0.1")
     *
     * @OA\SecurityScheme(
     *   type="oauth2",
     *   securityScheme="app_auth",
     *   @OA\Flow(
     *      tokenUrl="/api/v1/login",
     *      flow="password",
     *      scopes={
     *         "read": "read operations are available to the user",
     *         "write": "write operations are available to the user"
     *      }
     *   )
     * )
     *
     * @OA\Server(url=APP_URL)
     */
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
