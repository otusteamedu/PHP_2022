<?php
namespace Ppro\Hw28\Service\Statement;

/**
 *
 */
class Create extends Statement
{
    /**
     * @param array $payload
     * @return array
     */
    public function create(array $payload)
    {
        $data['request_id'] = $this->repository->setStatementRequest($payload);
        return $data;
    }
}