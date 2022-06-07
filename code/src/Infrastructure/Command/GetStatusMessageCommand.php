<?php

namespace App\Infrastructure\Command;


use App\Application\Service\ReportDataCommandService;
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
    private ReportDataCommandService $reportDataCommandService;

    public function __construct(MessageBusInterface $messageBus, ReportDataCommandService $reportDataCommandService)
    {
        $this->messageBus = $messageBus;
        $this->reportDataCommandService = $reportDataCommandService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('message', InputArgument::OPTIONAL, 'Message data')
            ->addOption('id', null, InputOption::VALUE_REQUIRED, 'Message Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $message = $input->getArgument('message');
        $id = $input->getOption('id');

        if (empty($message)) {
            $io->note(sprintf('You passed an argument: %s', $message)); exit;
        }

        if (empty($id)) {
            $io->note(sprintf('You passed an option: %s', $id)); exit;
        }

        $report = $this->reportDataCommandService->getStatus($id);

        $io->success("Статус: " . $report->getStatus()->getName());

        return Command::SUCCESS;
    }
}
