<?

declare(strict_types=1);

namespace Kogarkov\Es\Model;

class QueryModel
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

    public function setNumRows($num_rows): QueryModel
    {
        $this->num_rows = $num_rows;
        return $this;
    }

    public function setRow($row): QueryModel
    {
        $this->row = $row;
        return $this;
    }

    public function setRows($rows): QueryModel
    {
        $this->rows = $rows;
        return $this;
    }
}
