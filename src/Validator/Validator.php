<?php

namespace App\Validator;

use App\FileManager\FileManager;
use App\Validator\Contracts\ValidatorInterface;

class Validator
{
    private const OUTPUT = 'output.txt';


    public function __construct(
        private FileManager $fileManager,
        private ValidatorInterface $validator
    ) {}


    public function validate(string $path)
    {
        $input = $this->fileManager->open($path, 'r');
        $output = $this->fileManager->createOrOpen(self::OUTPUT, 'r+');

        $input->every(function ($value) use ($output) {
            $output->putLine($value . ' - ' . ($this->validator->validate($value) ? 'success' : 'false'));
        });

        $input->close();
        $output->close();
    }
}
