<?php
declare(strict_types=1);
namespace Mapaxa\BalancerApp\Controller;

use Mapaxa\BalancerApp\Service\Http\Response;
use Mapaxa\BalancerApp\Service\RoundBracesValidator;
use Mapaxa\BalancerApp\HandBook\HttpStatusHandbook;

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
            Response::setResponseCode(HttpStatusHandbook::OK);
        } else {
            $resultText = 'String is not valid';
            Response::setResponseCode(HttpStatusHandbook::BAD_REQUEST);
        }
    }

        require_once ('src/View/balancer/index.php');
    }
}