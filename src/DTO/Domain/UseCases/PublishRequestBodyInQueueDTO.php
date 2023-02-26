<?php

declare(strict_types=1);

namespace Src\DTO\Domain\UseCases;

final class PublishRequestBodyInQueueDTO
{
    public function __construct(
        public string $lastname,
        public string $firstname,
        public string $middle_name,
        public string $pass_number,
        public string $pass_place_code,
        public string $pass_issue_date,
        public string $email_callback,
    ) {
        //
    }
}
