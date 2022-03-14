<?php
declare(strict_types=1);
namespace Mapaxa\BalancerApp\Controller;


use Mapaxa\BalancerApp\Service\RoundBracesValidator;

class BracesController
{
    public function index(): void
    {

    if (filter_has_var(INPUT_POST, 'braces')) {
        $roundBracesValidator = new RoundBracesValidator();

        $stringWithBraces = filter_input(INPUT_POST, 'braces');
        $roundBracesAreValid = $roundBracesValidator->isValid($stringWithBraces);

        if ($roundBracesAreValid) {
            $resultText = 'String is valid';
            header("HTTP/1.1 200 Not Found");
        } else {
            $resultText = 'String is not valid';
            header("HTTP/1.1 400 Bad Request");
        }
    }

        require_once (ROOT.'/src/View/balancer/index.php');
    }
}