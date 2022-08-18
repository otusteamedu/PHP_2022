<?php
session_start();

class Api {

    private string $data;

    public function __construct()
    {
        $this->data = json_decode(
            file_get_contents('php://input'),
            true
        )['string'] ?? '';
    }

    private function analyze(): bool
    {
        $left = substr_count($this->data, '(');
        $right = substr_count($this->data, ')');

        return !($left !== $right || !$this->data || !$left && !$right);
    }

    public function respond(): void
    {
        if ($this->analyze()) {
            echo json_encode(session_id());
            exit;
        }
    }
}

$api = new Api();
$api->respond();
header('HTTP/1.1 400 Bad Request');
