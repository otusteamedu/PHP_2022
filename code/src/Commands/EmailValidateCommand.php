<?php

declare(strict_types=1);

namespace Ekaterina\Hw5\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Ekaterina\Hw5\Validators\FileValidator;
use Ekaterina\Hw5\Validators\EmailValidator;
use Exception;

class EmailValidateCommand extends Command
{
    /**
     * Конфигурация команды
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('email-validate')
            ->setDescription('Checking the validity of email addresses')
            ->addArgument('fileInput', InputArgument::REQUIRED, 'Pass the path to the file with email addresses (extensions: .txt, .log, .text, .err).');
    }

    /**
     * Выполнение команды
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = $input->getArgument('fileInput');
        try {
            $fileValidator = new FileValidator($fileName);
            if (!$fileValidator->isValid()) {
                $output->writeln(PHP_EOL . $fileName . ': ' .$fileValidator->getError() . PHP_EOL);
            } else {
                $fileContent = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $emailValidator = new EmailValidator($fileContent ?: []);
                $output->writeln([PHP_EOL . 'Результат проверки email-адресов', '====================================']);
                $this->viewArray($emailValidator->getResults(), $output);
            }
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

        return Command::FAILURE;
    }

    /**
     * Вывод массива результатов проверки
     *
     * @param array           $arEmails
     * @param OutputInterface $output
     * @return void
     */
    protected function viewArray(array $arEmails, OutputInterface $output)
    {
        foreach ($arEmails as $email => $data) {
            if ($data['valid']) {
                $content = "<info>$email - success</info>";
            } else {
                $content = "<error>$email - error</error>";
                if (!empty($data['description'])) {
                    $content .= " ({$data['description']})";
                }
            }
            $output->writeln( $content .PHP_EOL);
        }

    }
}