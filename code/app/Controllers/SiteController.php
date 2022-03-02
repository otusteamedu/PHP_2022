<?php

namespace App\Controllers;

use Core\Base\WebController;

class SiteController extends WebController
{
    /**
     * @return void
     * @throws \Core\Exceptions\InvalidArgumentException
     * @throws \JsonException
     */
    public function actionIndex()
    {
        if (count($this->request->all())) {
            try {
                $text = $this->request->get('string');
                $this->validator->validated($text, ['required', 'brackets']);
                if ($this->validator->check()) {
                    $this->response->sendToJSON([
                        'status' => 'success',
                        'msg' => 'Validate string is successful'
                    ]);
                } else {
                    $this->response->sendToJSON([
                        'status' => 'error',
                        'msg' => $this->validator->getErrors()
                    ], 400);
                }
            } catch (\Exception $e) {
               $this->response->sendToJSON([
                   'status' => 'error',
                   'msg' => $e->getMessage()
               ], 400);
            }
        }
    }

    /**
     * @return void
     */
    public function actionError()
    {
        echo 'You have error<br>';
    }
}