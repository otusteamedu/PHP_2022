<?php

namespace Otus\Task12\App\Infrastructure;

use Otus\Task12\Core\Repository;

class ProductRepository extends Repository
{
    public function getProductStatusAction(){
        $sql = "SELECT * FROM {$this->getEntityMetaData()->getTable()}";
        $this->statement($sql, [])->fetchAll(\PDO::FETCH_ASSOC);
    }
}