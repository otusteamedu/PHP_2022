<?php

declare(strict_types=1);

namespace App\Service;

class PostProcessor
{
    public static function process(): string
    {
        if (isset($_POST['string'])) {

            if (BracketsResolver::isBalanced($_POST['string'])) {
                return "Brackets are in order";
            }

            http_response_code(400);

            return "Brackets are not in order";
        }

        http_response_code(400);

        return "Empty string parameter";
    }
}