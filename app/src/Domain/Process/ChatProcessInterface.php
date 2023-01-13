<?php

namespace app\Domain\Process;

interface ChatProcessInterface {
    public function __construct(string $ownSocketFilename, string $serverFileName);
    public function getName(): string;
    public function run(): void;
}
