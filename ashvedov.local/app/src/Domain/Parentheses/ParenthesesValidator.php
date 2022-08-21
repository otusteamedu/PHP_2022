<?php

declare(strict_types=1);

namespace App\Src\Domain\Parentheses;

final class ParenthesesValidator
{
    private array $post_arr;

    /**
     * @param array $post_arr
     */
    public function __construct(array $post_arr)
    {
        $this->post_arr = $post_arr;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        if (! isset($this->post_arr['input_parentheses'])) {
            return false;
        }

        $string_parts = str_split(string: $this->post_arr['input_parentheses']);

        $stack = [];

        foreach ($string_parts as $part) {
            switch ($part) {
                case '(':
                    $stack[] = $part;
                    break;
                case ')':
                    if (array_pop($stack) !== '(') {
                        return false;
                    }
                    break;
                default:
                    break;
            };
        }

        return empty($stack);
    }
}
