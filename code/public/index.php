<?php


require '../vendor/autoload.php';

use Study\Cinema\App;


$shortopts  = "";
$shortopts .= "t:";
$shortopts .= "c::";
$shortopts .= "h";

$longopts  = array(
    "title:",
    "category::",
    "help",

);
$options = getopt($shortopts, $longopts);

$app = new App($options);
$app->run();




















