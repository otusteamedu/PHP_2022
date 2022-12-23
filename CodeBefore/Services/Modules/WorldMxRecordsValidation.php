<?php

declare(strict_types=1);

namespace Src\Services\Modules;

use GuzzleHttp\Client;
use Src\Exceptions\EmailValidatorException;
use Src\Services\Modules\Contracts\Validator;
use Src\Services\AdditionalServices\EmailHostnameExtractor;

final class WorldMxRecordsValidation implements Validator
{
    /**
     * @param string $email
     * @return string
     * @throws EmailValidatorException
     */
    public function validate(string $email): string
    {
        try {
            $client = new Client(config: ['base_uri' => 'https://dns.google/']);

            $google_response = $client
                ->request(method: 'GET', uri: 'resolve?name=' . $this->getHostname(email: $email) . '&type=MX')
                ->getBody()
                ->getContents();

            $google_response_to_array = json_decode(json: $google_response, associative: true);

            if (isset($google_response_to_array['Status']) && (int) $google_response_to_array['Status'] !== 0) {
                return 'world_mx_record_errors';
            }

            if (! isset($google_response_to_array['Answer'])) {
                return 'world_mx_record_errors';
            } else {
                foreach ($google_response_to_array['Answer'] as $answer) {
                    if ((int) $answer['type'] !== 15) {
                        return 'world_mx_record_errors';
                    }
                }
            }
        } catch (\Throwable $exception) {
            throw new EmailValidatorException(
                message: 'Method: ' . __METHOD__ . PHP_EOL
                . 'Error: ' . $exception->getMessage()
            );
        }

        return '';
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @param string $email
     * @return string
     */
    private function getHostname(string $email): string
    {
        $email_hostname_extractor = new EmailHostnameExtractor(email: $email);
        return $email_hostname_extractor->getHostname();
    }
}
