<?php

namespace App\Command;

use DOMDocument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Youtube\Channel\YoutubeChannelService;
use App\Service\Youtube\HttpChannel\HttpYoutubeChannelService;

#[AsCommand(
    name: 'youtube:channel:add',
    description: 'Add channel by id',
)]
class YoutubeAddChannelCommand extends Command
{
    public function __construct(
        private readonly YoutubeChannelService     $channelService,
        private readonly HttpYoutubeChannelService $httpChannelService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('value', InputArgument::REQUIRED, 'channel id');
        $this->addOption('type', null, InputArgument::OPTIONAL, 'id or link');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $value = $input->getArgument('value');
        $type = $input->getOption('type');
        if ($type === 'video-link') {
            $id = $this->getIdFromUrl($value);
        } elseif ($type === 'id' || empty($type)) {
            $id = $value;
        } else {
            $io->error('type can only be video-link or id');
            return Command::INVALID;
        }
        if (empty($id)) {
            $io->error('Channel id not found');
        }
        if ($this->channelService->existsById($id)) {
            $io->error('Channel is exists');
            return Command::INVALID;
        }
        $channel = $this->httpChannelService->findByIdWithSnippetOrFail($id);
        $io->success('Channel has been created');
        $this->channelService->save($channel);
        return Command::SUCCESS;
    }


    private function getIdFromUrl(string $url): ?string
    {
        $content = file_get_contents($url);
        $pattern = '/(\<meta itemprop=\"channelId\" content=\"){1}([\w])+(\">){1}/';
        preg_match($pattern, $content, $matches);
        if (!isset($matches[0])) {
            return null;
        }
        $id = $matches[0];
        $id = str_replace('">', '', $id);
        return str_replace('<meta itemprop="channelId" content="', '', $id);
    }
}
