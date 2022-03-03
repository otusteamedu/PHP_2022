<?php declare(strict_types=1);

namespace Queen\App\Controllers;

use Exception;
use Queen\App\EmailChecker\EmailChecker;

class EmailController extends DefaultController
{
    const VALID_RESULT   = 'valid email';
    const INVALID_RESULT = 'invalid email';
    const SUCCESS_CLASS  = 'badge bg-success';
    const ERROR_CLASS    = 'badge bg-danger';

    /**
     * @throws Exception
     */
    public function index()
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . $_ENV['EMAIL_LIST_FILE'];
        $array = [];
        $error = '';

        $validator = new EmailChecker();

        try {
            if (!file_exists($file)) {
               throw new \Exception('File not found');
            }

            $lines = file($file);

            foreach ($lines as $key => $line) {
                $check = $validator->checkEmail($line);
                $array[] = [
                    'index' => $key + 1,
                    'email' => $line,
                    'check' => $check ? self::VALID_RESULT : self::INVALID_RESULT,
                    'class' => $check ? self::SUCCESS_CLASS : self::ERROR_CLASS
                ];
            }
        } catch (Exception $exception) {
            $error = $exception->getMessage();
        }

        $this->render('email', ['emails' => $array, 'error' => $error]);
    }
}
