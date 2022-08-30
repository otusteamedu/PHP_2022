<?php

namespace Mselyatin\Queue\infrastructure\controllers\http;

use Mselyatin\Queue\Application;
use Mselyatin\Queue\infrastructure\abstracts\ControllerAbstract;
use Mselyatin\Queue\infrastructure\jobs\QueueBankDetailsJob;

/**
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
class FormController extends ControllerAbstract
{
    /**
     * Add new blank to processing
     * @return void
     */
    public function addBlankDetails(): void
    {
        $request = $this->request;
        $blankBtn = $request->get('blank_btn');
        $text = $request->get('text');

        if ($blankBtn && $text) {
            $queueManager = Application::$app->getQueueManager();
            $job = new QueueBankDetailsJob(
                [
                    'text' => $text
                ]
            );

            $jobId = $queueManager->push($job, 'app');
            if ($jobId) {
                var_dump('Success');
            } else {
                var_dump('Unknown error!');
            }
        }
    }
}