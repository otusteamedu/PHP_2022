<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Youtube\Channel\YoutubeChannelService;

#[AsCommand(
    name: 'youtube:channel:statistics',
    description: 'display channel statistics',
)]
class YoutubeChannelStatisticsCommand extends Command
{
    public function __construct(
        private readonly YoutubeChannelService $channelService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $items = $this->channelService->getStatistics(1000);

        $items = array_map(function ($item) {
            return [
                $item['title'],
                number_format($item['amountViews'], 0, '.', ' '),
                number_format($item['amountLikes'], 0, '.', ' '),
                number_format($item['rating'], 4, '.', ' '),
            ];
        }, $items);
        $io = new SymfonyStyle($input, $output);
        $io->table(['Title', 'Amount Views', 'Amount Likes', 'Rating'], $items);
        return Command::SUCCESS;
    }
}
