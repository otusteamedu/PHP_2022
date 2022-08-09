<?php

declare(strict_types = 1);

namespace App\Application;

use App\Domain;
use App\Infrastructure;

class App
{
    protected string $inputFile;
    protected array $request;

    /**
     * @param string $inputFile
     */
    public function __construct()
    {
        GLOBAL $argv;
        $this->inputFile = isset($argv[1]) ? $argv[1] : null;
        $this->request = isset($_REQUEST) ? $_REQUEST : null;
    }


    public function run() : void
    {

        try {
            if (PHP_SAPI == 'cli')
            {
                $App = new CheckEmailApp(new Infrastructure\Cli\UploadEmailContacts($this->inputFile), new Infrastructure\Cli\Result());
            }
            else
            {
                $App = new CheckEmailApp(new Infrastructure\Http\UploadEmailContacts(isset($this->request['emails']) ? $this->request['emails'] : NULL), new Infrastructure\Http\Result());
            }
            $App->checkEmails(new Utils\CheckEmail());
            $App->printResult();
        }  catch(\Exception $exception) {
            echo "Произошла ошибка: " . $exception->getMessage();
        }
        catch(\TypeError $exception) {
            echo "Произошла ошибка: " . $exception->getMessage();
        }
    }
}