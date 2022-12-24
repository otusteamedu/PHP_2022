<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\App\Kernel;

class Response
{
    public static function json(int $code, array $res = []): string
    {
        try {
            http_response_code($code);
            return match ($code) {
                400 => '400 Bad Request',
                default => !$res ? '200 OK' : json_encode($res),
            };
        } catch (\Exception $exception) {
            http_response_code(500);
            return '500 Server error';
        }
    }

    public static function render(string $path = "", array $response = []): string
    {
        if ($path == "") {
            $path = __DIR__ . "/../templates/main.php";
        }
        ob_start();
        $data = $response;
        require $path;
        return ob_get_clean();
    }
}
