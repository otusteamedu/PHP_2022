<?php

require('vendor/autoload.php');

$app = \Mselyatin\Project5\classes\Application::create(
    new \Mselyatin\Project5\classes\Request(),
    new \Mselyatin\Project5\classes\JSONResponse()
);
$app->run();

echo '</br></br>';
echo "Hostname: " . $_SERVER['HOSTNAME'];