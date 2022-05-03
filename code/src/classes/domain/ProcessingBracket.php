<?php

declare(strict_types=1);

namespace Mselyatin\Project5\classes\domain;

/**
 * @ProcessingBracket
 * @\Mselyatin\Project5\classes\domain\ProcessingBracket
 * @author Михаил Селятин
 */
class ProcessingBracket
{
    /** @var ?string  */
    private ?string $brackets;

    public function __construct(?string $brackets)
    {
        $this->brackets = $brackets;
    }


    /**
     * @throws \RuntimeException
     */
    public function processing(): void
    {
        if ($this->isEmpty() || !$this->isValid()) {
            throw new \RuntimeException(
                'String is not valid',
                -1
            );
        }
    }

    /**
     * @return bool
     */
    private function isEmpty(): bool
    {
        if (empty($this->brackets)) {
            return true;
        }

        return false;
    }

    /**
     * Алгорит валидации
     * @return bool
     */
    private function isValid(): bool
    {
        $openingBracket = "(";
        $closingBracket = ")";

        $amountOpeningBrackets = substr_count($this->brackets, $openingBracket);
        $amountClosingBrackets = substr_count($this->brackets, $closingBracket);

        $amountValid = $amountOpeningBrackets === $amountClosingBrackets;

        if ($amountValid) {
            $i = 1; // номер скобки в строке
            $counter = 0;
            $arBrackets = str_split($this->brackets);

            foreach ($arBrackets as $bracket) {

                if (($i === 1) && $bracket === $closingBracket) {
                    return false;
                }

                $counter = $bracket === $openingBracket ? ++$counter : --$counter;

                if ($counter < 0) {
                    return false;
                }

                $i++;
            }

            return $counter === 0;
        }

        return false;
    }
}