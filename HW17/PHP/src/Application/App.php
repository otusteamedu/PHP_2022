<?php

declare(strict_types = 1);

namespace App\Application;

use App\Domain;
use App\Infrastructure;

class App
{
    public function run(array $argv) : void
    {

        try {
            if (PHP_SAPI == 'cli')
            {
                $App = new CheckEmailApp(new Infrastructure\Cli\UploadEmailContacts($argv[1] ?? NULL), new Infrastructure\Cli\Result());
            }
            else
            {
                $App = new CheckEmailApp(new Infrastructure\Http\UploadEmailContacts(isset($_REQUEST['emails']) ? $_REQUEST['emails'] : NULL), new Infrastructure\Http\Result());
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