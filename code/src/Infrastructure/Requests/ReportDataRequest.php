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
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z -].$/i",
     * )
     */
    private readonly string $name;

    /**
     * @var string
     * @Assert\Url(protocols = {"http"})
     */
    private readonly string $url;

    protected ValidatorInterface $validator;

    public function __construct(RequestStack $requestStack, ValidatorInterface $validator)
    {
        $request = $requestStack->getCurrentRequest();

        $this->name = $request->get('name') ?? '';
        $this->url = $request->get('url') ??  '' ;

        $this->validator = $validator;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'url' => $this->getUrl()
        ];
    }
}