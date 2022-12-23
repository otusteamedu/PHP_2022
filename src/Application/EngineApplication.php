<?php

declare(strict_types=1);

namespace Src\Application;

use Src\Application\Exceptions\{
    MxRecordsValidationException,
    RegexpValidationException,
    SimpleValidationException,
    WorldMxRecordsValidationException
};
use Src\Domain\Contracts\HttpGateway\HttpClient;
use Src\Domain\Contracts\EmailHostnameExtractorContract;
use Src\Domain\UseCases\{MxRecordsValidation, RegexpValidation, SimpleValidation, WorldMxRecordsValidation};

final class EngineApplication
{
    /**
     * @var EmailHostnameExtractorContract
     */
    private EmailHostnameExtractorContract $email_hostname_extractor;

    /**
     * @var HttpClient
     */
    private HttpClient $http_client;

    /**
     * @var string
     */
    private string $email;

    /**
     * @param EmailHostnameExtractorContract $email_hostname_extractor
     * @param HttpClient $http_client
     */
    public function __construct(EmailHostnameExtractorContract $email_hostname_extractor, HttpClient $http_client)
    {
        $this->email_hostname_extractor = $email_hostname_extractor;
        $this->http_client = $http_client;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return clone $this;
    }

    /**
     * @return $this
     * @throws MxRecordsValidationException
     */
    public function mxRecordsValidation(): self
    {
        $mx_records_validation_validation_case = new MxRecordsValidation();

        $mx_records_validation_validation_case
            ->validate(
                email_hostname: $this->email_hostname_extractor->getHostname(email: $this->email)
            );

        return clone $this;
    }

    /**
     * @return $this
     * @throws WorldMxRecordsValidationException
     */
    public function worldMxRecordsValidation(): self
    {
        $world_mx_records_validation_case = new WorldMxRecordsValidation(http_client: $this->http_client);

        $world_mx_records_validation_case
            ->validate(
                email_hostname: $this->email_hostname_extractor->getHostname(email: $this->email)
            );

        return clone $this;
    }

    /**
     * @return $this
     * @throws RegexpValidationException
     */
    public function regexpValidation(): self
    {
        $regexp_validation_case = new RegexpValidation();

        $regexp_validation_case->validate(email: $this->email);

        return clone $this;
    }

    /**
     * @return $this
     * @throws SimpleValidationException
     */
    public function simpleValidation(): self
    {
        $simple_validation_case = new SimpleValidation();

        $simple_validation_case->validate(email: $this->email);

        return clone $this;
    }
}
