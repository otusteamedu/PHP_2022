<?php

declare(strict_types=1);

namespace Chernysh\Hw4\Service;

class CheckStringService implements ServiceInterface
{
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

        $counter = 0;
        foreach (mb_str_split($string) as $char) {
            if ($char === '(') {
                $counter++;
                continue;
            }
            if ($char === ')') {
                if ($counter === 0) {
                    throw new ServiceException('Для закрытой скобки нет соответствующей открытой скобки');
                }
                $counter--;
                continue;
            }
            throw new ServiceException(sprintf('Невалидный символ «%s»', $char));
        }

        if ($counter > 0) {
            throw new ServiceException('Для открытой скобки нет соответствующей закрытой скобки');
        }

        return true;
    }
}
