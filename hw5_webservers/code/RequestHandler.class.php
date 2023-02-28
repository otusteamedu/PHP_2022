<?php

namespace Validator;

require_once("BracketsChecker.class.php");

use \Validator\BracketsChecker;

/**
 * Class for Otus HW #5
 */
class RequestHandler
{
    /**
     * @param array $params
     * @return int
     */
    public function handlePostRequest(array $params): void
    {
        $string = (isset($params['string']) ? $params['string'] : '');
        $validator = new BracketsChecker();
        $valid = $validator->validateString($string);
        $code = ($valid ? 200 : 400);
        $fix = "Response from ". $_SERVER['HOSTNAME'];

        switch($code) {
            case 200:
                header ( "SUCCESS: string is correct ($fix)", true, $code);
                break;

            case 400:
                header ( "FAIL: incorrect string ($fix)", true, $code);
                break;

            default:
                header ( "FAIL: unknown error ($fix)", true, $code);
                break;
        }
    }
}

