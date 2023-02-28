<?php

namespace App\Validator;

use App\FileManager\FileManager;
use App\Validator\Interfaces\ValidatorInterface;

class Validator
{
    private const OUTPUT = 'output.txt';


    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private FileManager $fileManager,
        private ValidatorInterface $validator
    ) {
    }


    /**
     * validate
     *
     * @param  mixed $path
     * @return void
     */
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