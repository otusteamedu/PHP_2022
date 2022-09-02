<?php

declare(strict_types=1);

namespace Nikolai\Php;

use Nikolai\Php\Service\EmailsFromFileVerifierService;
use Nikolai\Php\Service\EmailVerifier;
use Nikolai\Php\Configuration;

class Application implements ApplicationInterface
{
    public function run(): void
    {
        try {
            $configurationLoader = new Configuration\ConfigurationLoader(dirname(__DIR__) . '/config/services.yaml');
            $configuration = $configurationLoader->load();

            $stringVerifier = new EmailVerifier();
            $emailsFromFileVerifierService = new EmailsFromFileVerifierService(
                dirname(__DIR__) . $configuration['parameters']['emailsFile'],
                $stringVerifier
            );

            $result = $emailsFromFileVerifierService->verify();

            echo '<br>Результаты проверки:<br><pre>';
            var_dump($result);
            echo '</pre>';

        } catch (\Exception $exception) {
            echo '<br>Исключение: ' . $exception->getMessage() . '<br>';
        }
    }
}