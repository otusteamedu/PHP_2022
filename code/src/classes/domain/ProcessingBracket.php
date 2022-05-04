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

        $i = 1; // номер скобки в строке
        $counter = 0;
        $bracketLength = strlen($this->brackets ?? '');

        for($j = 0; $j < $bracketLength; $j++) {

            $bracket = $this->brackets[$j];

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
}