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
        try {
            if ($this->request->getMethod() === HttpRequest::POST) {
                if (!preg_match('~\((\)*\)*)\)~', $string = $this->request->getParameter('string'))) {
                    throw new Exception(self::ERROR);
                }

                $len = strlen($string);

                $brackets = [];
                for ($i = 0; $i < $len; $i++) {
                    $symbol = $string[$i];
                    if ($symbol == '(') {
                        $brackets[] = $symbol;
                    } elseif ($symbol == ')') {
                        if (!$last = array_pop($brackets)) {
                            throw new Exception(self::ERROR);
                        }

                        if ($symbol === ')' && $last != '(') {
                            throw new Exception(self::ERROR);
                        }
                    }
                }
                $res =  count($brackets) === 0 ? self::SUCCESS : '';
                $this->response->redirect('form', 301, $res);
                echo $this->response->getContent();
            }
        } catch (Exception $exception) {
            $this->response->redirect('form', 400, $exception->getMessage());
            echo $this->response->getContent();
        }

        $this->render('form');
    }
}
