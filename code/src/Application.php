<?php

declare(strict_types=1);

namespace Nikolai\Php;

use Nikolai\Php\Configuration\ConfigurationLoaderInterface;
use Nikolai\Php\Service\Dumper;
use Nikolai\Php\Service\DumperInterface;
use Nikolai\Php\Service\EmailsFromFileVerifierService;
use Nikolai\Php\Service\EmailVerifier;
use Nikolai\Php\Configuration;

class Application implements ApplicationInterface
{
    const RESULT_HEADER = 'Результаты проверки';
    const EXCEPTION_HEADER = 'Исключение';
    const CONFIGURATION_FILE = '/config/services.yaml';

    private DumperInterface $dumper;
    private ConfigurationLoaderInterface $configurationLoader;

    public function __construct()
    {
        $this->dumper = new Dumper();
        $this->configurationLoader = new Configuration\ConfigurationLoader(
            dirname(__DIR__) . self::CONFIGURATION_FILE
        );
    }

    public function run(): void
    {
        try {
            $configuration = $this->configurationLoader->load();

            $stringVerifier = new EmailVerifier();
            $emailsFromFileVerifierService = new EmailsFromFileVerifierService(
                dirname(__DIR__) . $configuration['parameters']['emailsFile'],
                $stringVerifier
            );

            $result = $emailsFromFileVerifierService->verify();
            $this->dumper->dump(self::RESULT_HEADER, $result);
        } catch (\Exception $exception) {
            $this->dumper->dump(self::EXCEPTION_HEADER, $exception->getMessage());
        }
    }
}