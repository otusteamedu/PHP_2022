<?php

namespace App\Command;

use App\Service\Youtube\Channel\YoutubeChannelService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'youtube:channel:delete',
    description: 'Delete channel by id',
)]
class YoutubeDeleteChannelCommand extends Command
{
    public function __construct(
        private readonly YoutubeChannelService $channelService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::REQUIRED, 'channel id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('id');
        $channel = $this->channelService->findById($id);
        if (empty($channel)) {
            $io->error('Channel not found');
            return Command::INVALID;
        }
        $this->channelService->delete($channel);
        $io->success('Channel has been deleted');
        return Command::SUCCESS;
    }
}
