<?php

namespace Mselyatin\Queue\infrastructure\jobs;

use Mselyatin\Queue\application\abstracts\QueueJobAbstract;

/**
 * @property array $data
 *
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
class QueueBankDetailsJob extends QueueJobAbstract
{
    protected function prepareData(): void
    {
        // TODO: Implement prepareData() method.
    }

    public function handle(): void
    {
        var_dump("Данные задачи: " . json_encode($this->data));
        echo PHP_EOL;
        var_dump("Обработка данных....");
        echo PHP_EOL;
        var_dump("Данные успешно обработаны, задача завершена");
        echo PHP_EOL;
    }
}