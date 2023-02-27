<?php

/**
 * Class for Otus HW #5
 */
class BracketsChecker
{
    /**
     * @param $string
     * @return bool
     */
    public function validateString($string): bool
    {
        if(!$string) {
            return false;
        }

        if(!$this->regExpBracketsCheck($string)) {
            return false;
        }

        return true;
    }

    /**
     * @param array $params
     * @return int
     */
    public function handlePostRequest(array $params): void
    {
        $string = (isset($params['string']) ? $params['string'] : '');
        $valid = $this->validateString($string);
        $code = ($valid ? 200 : 400);
        $fix = "Response from ". $_SERVER['HOSTNAME'];

        switch($code) {
            case 200:
                header ( "SUCCESS: string is correct ($fix)", true, $code);
                break;

            case 400:
                header ( "FAIL: icorrect string ($fix)", true, $code);
                break;

            default:
                header ( "FAIL: unknow error ($fix)", true, $code);
                break;
        }
    }

    /**
     * Check that string contain right brackets expression
     * @param string $string
     * @return bool
     */
    public function regExpBracketsCheck(string $string): bool
    {
        $regexp = '/^[^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)++$/';
        if (preg_match($regexp, $string)) {
            return true;
        }

        return false;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//echo "Hello, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";
//echo "Handled by PHP-FPM container: " . $_SERVER['HOSTNAME'];

$checker = new BracketsChecker();

//$string = "())";
//echo "Result: " . ($checker->regExpBracketsCheck($string) ? "T" : "F");

$checker->handlePostRequest($_POST);

