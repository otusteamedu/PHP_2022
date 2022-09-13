<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

class EmailsFromFileVerifierService implements VerifierServiceInterface
{
    public function __construct(
        private string $emailsFile,
        private StringVerifierInterface $stringVerifier
    ) {}

    public function verify(): array
    {
        // Ключ - строка из файла, значение - результат проверки
        $verifiedStrings = [];

        if (!file_exists($this->emailsFile)) {
            throw new \Exception('Файл: ' . $this->emailsFile . ' не найден!');
        }

        $file = fopen($this->emailsFile,'r');
        while ($string = fgets($file)) {
            $string = str_replace(["\r\n", "\r", "\n"], '',  $string);
            try {
                $verifiedStrings[$string] = $this->stringVerifier->verify($string);
            } catch (\Exception $exception) {
                $verifiedStrings[$string] = $exception->getMessage();
            }
        }
        fclose($file);

        return $verifiedStrings;
    }
}