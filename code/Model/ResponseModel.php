<?

declare(strict_types=1);

namespace Model;

class ResponseModel
{
    private $status_code;

    private $message = null;

    public function getStatusCode() : int
    {
        return $this->status_code;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function __construct(int $status_code, string $message = null)
    {
        $this->status_code = $status_code;
        $this->message = isset($message) && $message != null ? $message : null;
    }

    public function toArray(): array
    {
        return [
            'status_code' => $this->status_code,
            'message' => $this->message
        ];
    }

    public function toJson(): string
    {
        return json_encode([
            'status_code' => $this->status_code,
            'message' => $this->message
        ]);
    }
}
