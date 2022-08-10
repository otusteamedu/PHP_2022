<?php

declare(strict_types = 1);

namespace App\Application;

use App\Application\Utils\CheckEmail;
use App\Domain;
use App\Infrastructure;

class App
{
    protected \App\Application\CheckEmailApp $EmailApp;

    /**
     * @param string $inputFile
     */
    public function __construct()
    {
        GLOBAL $argv;
        if (PHP_SAPI == 'cli')
        {
            $this->EmailApp = new CheckEmailApp(new Infrastructure\Cli\UploadEmailContacts($argv[1] ?? null), new Infrastructure\Cli\Result());
        }
        else
        {
            $this->EmailApp = new CheckEmailApp(new Infrastructure\Http\UploadEmailContacts($_REQUEST['emails'] ?? NULL), new Infrastructure\Http\Result());
        }
    }

    public function run() : void
    {
        $this->EmailApp->checkEmails(new Utils\CheckEmail());
        $this->EmailApp->printResult();
    }
}