<?php

declare(strict_types=1);

namespace Chernysh\Hw4\Service;

class CheckStringService implements ServiceInterface
{

    private int $counter = 0;


    /**
     * @throws ServiceException
     */
    public function check(array $params): bool
    {

        if (!isset($params['string'])) {
            throw new ServiceException('Необходимо указать параметр $string');
        }

        $string = trim($params['string']);
        if (!$string) {
            throw new ServiceException('Параметр $string не может быть пустым');
        }

        $this->counter = 0;
        foreach (mb_str_split($string) as $char) {
            switch ($char) {
                case '(':
                    $this->incrementCounter();
                    break;
                case ')':
                    $this->decrementCounter();
                    break;
                default:
                    throw new ServiceException(sprintf('Невалидный символ «%s»', $char));
            }
        }

        if ($this->counter > 0) {
            throw new ServiceException('Для открытой скобки нет соответствующей закрытой скобки');
        }

        return true;
    }


    private function incrementCounter(): void
    {
        $this->counter++;
    }

    private function decrementCounter(): void
    {
        if ($this->counter === 0) {
            throw new ServiceException('Для закрытой скобки нет соответствующей открытой скобки');
        }
        $this->counter--;
    }
}