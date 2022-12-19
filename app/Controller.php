<?php

namespace Otus\Task06\App;

use Otus\Task06\App\Services\EmailReaderService;
use Otus\Task06\App\Validation\Rules\EmailDNSRule;
use Otus\Task06\App\Validation\Rules\EmailRule;
use Otus\Task06\Core\Validation\Validator;
use Otus\Task06\Core\Application;
use Otus\Task06\Core\Http\Response;


class Controller
{
    public function __construct(private Application $application){}

    public function __invoke(): Response
    {
        try{
            $view = $this->application->getContainer('view');
            $config = $this->application->getContainer('config');
            $file = new EmailReaderService($config['path_to_email']);
            $emails = [];

            foreach ($file->getEmails() as $email) {
                $validator = Validator::make($email, [new EmailRule(), new EmailDNSRule()]);
                $emails[$email] = $validator->isValid();
            }
            return new Response($view->make(compact('emails'), 'app'));

        }catch (\Exception $exception){
            return new Response($exception->getMessage(), status: 500);
        }
    }

}