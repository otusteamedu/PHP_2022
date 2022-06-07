<?php

declare(strict_types=1);

namespace App\Infrastructure\Requests;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReportDataRequest extends BaseRequest
{
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z -]+$/i",
     * )
     */
    private string $message;

    protected ValidatorInterface $validator;

    public function __construct(RequestStack $requestStack, ValidatorInterface $validator)
    {
        $request = $requestStack->getCurrentRequest();

        $this->message = $request->get('message');

        $this->validator = $validator;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}