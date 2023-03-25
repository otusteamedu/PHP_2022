<?php
namespace Ppro\Hw28\Service\Statement;
/**
 *
 */
class GetOne extends Statement
{
    /**
     * @param int $id
     * @return array
     */
    public function getOne(int $id)
    {
        return $this->repository->getStatementRequest($id);
    }
}