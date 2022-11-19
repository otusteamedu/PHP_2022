<?php

declare(strict_types=1);

namespace Eliasjump\EmailVerification;

use Exception;

class Application
{
    private array $emails;
    public array $response = ['emails' => [], 'errors' => []];

    public function __construct()
    {
        $this->emails = isset($_POST['emails']) ? explode("\n", $_POST['emails']) : [];
        $this->response['emails'] = $this->emails;
    }

    public function run(): void
    {
        try {
            $validator = new EmailValidator();
            foreach ($this->emails as $email) {
                try {
                    $validator->validate($email);
                } catch (ValidateException $validateException) {
                    http_response_code($validateException->httpCode);
                    $this->response['errors'][] = $validateException->getMessage();
                }
            }
            echo $this->renderTemplate();
        } catch (Exception $exception) {
            http_response_code(500);
            echo "500 Ошибка сервера" . PHP_EOL;
            echo $exception->getMessage();
        }
    }

    private function renderTemplate(): bool|string
    {
        ob_start();
        $response = $this->response;
        require __DIR__ . '/template.php';

        return ob_get_clean();
    }
}
