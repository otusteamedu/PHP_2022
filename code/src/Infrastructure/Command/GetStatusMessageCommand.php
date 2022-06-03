<?php

namespace App\Infrastructure\Command;


use App\Application\Service\ReportDataService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:get-status-message',
    description: 'Add a short description for your command',
)]
class GetStatusMessageCommand extends Command
{
    private MessageBusInterface $messageBus;
    private ReportDataService $reportDataService;

    public function __construct(MessageBusInterface $messageBus, ReportDataService $reportDataService)
    {
        $this->messageBus = $messageBus;
        $this->reportDataService = $reportDataService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('message', InputArgument::OPTIONAL, 'Message data')
            ->addOption('id', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $messageArg = $input->getArgument('message');
        $idQueque = $input->getOption('id');

        if (empty($messageArg)) {
            $io->note(sprintf('You passed an argument: %s', $messageArg)); exit;
        }

        if (empty($idQueque)) {
            $io->note(sprintf('You passed an option: %s', $idQueque)); exit;
        }

        $report = $this->reportDataService->getStatus($idQueque);

        $io->success("Статус" . $report->getStatus()->getName());

        return Command::SUCCESS;
    }
}
