<?

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Contract;

interface QueryInterface
{
    public function getNumRows(): int;
    public function getOne(): array;
    public function getAll(): array;
    public function setNumRows($num_rows): QueryInterface;
    public function setRow($row): QueryInterface;
    public function setRows($rows): QueryInterface;
}
