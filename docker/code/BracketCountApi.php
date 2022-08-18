<?php
session_start();

class BracketCountApi {

    private string $data;

    public function __construct()
    {
        $this->data = json_decode(
            file_get_contents('php://input'),
            true
        )['string'] ?? '';

        if (!$this->data) {
            $this->data = $_POST['string'] ?? '';
        }
    }

    private function analyze(): bool
    {
        $left = '(';
        $right = ')';
        $brackets = [];

        $string = str_split($this->data);
        if (count($string) % 2 || $string[0] !== $left || $string[count($string) - 1] !== $right) {
            return false;
        }

        foreach ($string as $bracket) {
            if ($bracket === $left) {
                $brackets[] = $left;
            } elseif ($bracket === $right && count($brackets)) {
                array_pop($brackets);
            } else {
                return false;
            }
        }

        return !count($brackets);
    }

    public function respond(): void
    {
        if (!$this->analyze()) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }
        echo json_encode([session_id(), $_SERVER['HOSTNAME']]);
    }
}

$api = new BracketCountApi();
$api->respond();
exit;
