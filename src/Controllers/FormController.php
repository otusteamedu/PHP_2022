<?php declare(strict_types=1);

namespace Queen\App\Controllers;

use Exception;
use Queen\App\Core\Http\HttpRequest;

class FormController extends DefaultController
{
    const ERROR = 'String is not valid';
    const SUCCESS = 'String is valid';

    /**
     * @return void
     */
    public function index()
    {
        $params = [];
        $string = '';
        try {
            if ($this->request->getMethod() === HttpRequest::POST) {

                $string = $this->request->getParameter('string');

                if (empty($string)) {
                    throw new Exception(self::ERROR);
                }

                if (!preg_match('~\((\)*\)*)\)~', $string)) {
                    throw new Exception(self::ERROR);
                }

                $open = 0;
                $close = 0;
                for ($i = 0; $i < strlen($string); $i++) {
                    if ($string[$i] === '(') $open++;
                    if ($string[$i] === ')') $close++;
                }

                if ($open !== $close) {
                    throw new Exception(self::ERROR);
                }

                $params = [
                    'result' => self::SUCCESS,
                    'class' => 'badge bg-success',
                    'value' => $string,
                ];
            }
        } catch (Exception $exception) {
            $params = [
                'result' => $exception->getMessage(),
                'class' => 'badge bg-danger',
                'value' => $string,
            ];
        }

        $this->render('form', $params);
    }
}
