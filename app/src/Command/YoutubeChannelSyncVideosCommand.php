<?php

namespace App\Command;

use App\Service\Youtube\Channel\YoutubeChannelService;
use App\Service\Youtube\HttpVideo\HttpYoutubeVideoService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'youtube:channel:sync-videos',
    description: 'sync video with channels',
)]
class YoutubeChannelSyncVideosCommand extends Command
{
    public function __construct(
        private readonly YoutubeChannelService   $channelService,
        private readonly HttpYoutubeVideoService $videoService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $channels = $this->channelService->getAll();
        $progressBar = new ProgressBar($output, count($channels));
        $progressBar->start();
        foreach ($channels as $channel) {
            $videos = $this->videoService->getVideosByChannel($channel);
            $this->channelService->syncVideos($channel, $videos);
            $progressBar->advance();
        }
        $progressBar->finish();
        return Command::SUCCESS;
    }
}
