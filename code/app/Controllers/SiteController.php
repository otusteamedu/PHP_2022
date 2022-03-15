<?php

namespace App\Controllers;

use Core\Base\WebController;
use Core\Helpers\Mail;
use Core\Widgets\Alert;

class SiteController extends WebController
{
    /**
     * @return void
     * @throws \Core\Exceptions\InvalidArgumentException
     * @throws \JsonException
     */
    public function actionIndex()
    {
        if ($this->request->has('email')) {
            try {
                $email = $this->request->get('email');
                $this->validator->validated($email, ['required', 'email']);
                if ($this->validator->check()) {
                    if ($dns = Mail::mxRecordValidate($email)) {
                        $this->session->alertMessage()->setFlashMessage('success', $email . ' validate email is successful', Alert::FLASH_SUCCESS);
                        $this->session->alertMessage()->setFlashMessage('mx_record', 'This MX records exists: target - ' . $dns, Alert::FLASH_INFO);
                    } else {
                        $this->session->alertMessage()->setFlashMessage('error', 'This MX records is not exists for email ' . $email, Alert::FLASH_ERROR);
                    }
                } else {
                    $this->session->alertMessage()->setFlashMessage('error', $this->validator->getErrorsToString(), Alert::FLASH_ERROR);
                }
            } catch (\Exception $e) {
                $this->session->alertMessage()->setFlashMessage('error', $e->getMessage(), Alert::FLASH_ERROR);
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