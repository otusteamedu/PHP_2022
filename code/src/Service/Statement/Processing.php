<?php
namespace Ppro\Hw28\Service\Statement;

/**
 *
 */
class Processing extends Statement
{
    public function run()
    {
        $this->repository->processingStatementQueue();
    }
}