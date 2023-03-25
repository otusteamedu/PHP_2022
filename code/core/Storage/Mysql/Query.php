<?

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Mysql;

use Kogarkov\Es\Core\Storage\Contract\QueryInterface;

class Query implements QueryInterface
{
    private $num_rows;
    private $row;
    private $rows;

    public function getNumRows(): int
    {
        return $this->num_rows;
    }

    public function getOne(): array
    {
        return $this->row;
    }

    public function getAll(): array
    {
        return $this->rows;
    }

    public function setNumRows($num_rows): Query
    {
        $this->num_rows = $num_rows;
        return $this;
    }

    public function setRow($row): Query
    {
        $this->row = $row;
        return $this;
    }

    public function setRows($rows): Query
    {
        $this->rows = $rows;
        return $this;
    }
}
