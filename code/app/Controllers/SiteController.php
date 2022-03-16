<?php

namespace App\Controllers;

use App\Application;
use Core\Base\WebController;
use Core\Exceptions\InvalidArgumentException;
use Core\Helpers\Mail;
use Core\Widgets\Alert;

class SiteController extends WebController
{
    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function actionIndex()
    {
        if ($this->request->has('email')) {
            try {
                $email = $this->request->get('email');
                Mail::checkEmail($email);
            } catch (InvalidArgumentException $e) {
                Application::$app->getSession()
                                 ->alertMessage()
                                 ->setFlashMessage('error', $e->getMessage(), Alert::FLASH_ERROR);
            }
        }

        view('index');
    }

    /**
     * @return void
     */
    public function actionError()
    {
        view('404');
    }
}