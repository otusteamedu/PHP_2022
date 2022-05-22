<?php

// Checking current host
header("Instance: ".$_SERVER['HOSTNAME']);

if (isset($_POST['string'])) {

    if (isBalanced($_POST['string'])) {
        echo "Brackets are in order";
    } else {
        http_response_code(400);
        echo "Brackets are not in order";
    }

    return;
}

http_response_code(400);
echo "Empty string parameter";

//======

function isBalanced($str): bool
{
    $str = getBrackets($str);

    return areBracketsInOrder($str);
}

function getBrackets($str): string
{
    $re = "/[^()\[\]{}]/";

    return preg_replace($re, '', $str);
}

function areBracketsInOrder($str): bool
{
    $len = strlen($str);

    $bracket = ["]" => "[", "}" => "{", ")" => "("];

    $openBrackets = [];
    $isClean = true;

    for ($i = 0; $isClean && $i < $len; $i++) {
        if (array_key_exists($str[$i], $bracket)) { // found closing bracket
            $isClean = (array_pop($openBrackets) === $bracket[$str[$i]]);
        } else {
            $openBrackets[] = $str[$i];
        }
    }

    return $isClean && (count($openBrackets) === 0);
}