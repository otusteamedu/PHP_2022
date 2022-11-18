<?php

declare(strict_types=1);

namespace Eliasjump\EmailVerification;

class Application
{
    private array $emails;
    public array $response = ['emails' => [], 'errors' => []];

    public function __construct()
    {
        $this->emails = isset($_POST['emails']) ? explode("\n", $_POST['emails']) : [];
        $this->response['emails'] = $this->emails;
    }

    public function run(): array
    {
        $validator = new EmailValidator();
        foreach ($this->emails as $email) {
            try {
                $validator->validate($email);
            } catch (ValidateException $validateException) {
                $this->response['errors'][] = $validateException->getMessage();
            }
        }
        if (!empty($this->response['errors'])) {
            http_response_code(422);
        }
        return $this->response;
    }
}
