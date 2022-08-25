<?php

require_once("EmailValidator.php");
require_once("FilesProcessor.php");

use FilesProcessor;
use EmailValidator;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// START

$proc = new FilesProcessor();

$IN_FILE = "emails.txt";
$OUT_FILE = "valid_emails.txt";

echo "START emails filtering ...\n";
echo "Reading file '$IN_FILE' ...\n";

$emails = $proc->readFile($IN_FILE);
$new_emails = $proc->processFileData($emails);
$proc->writeFile($OUT_FILE, $new_emails);

echo "FINISH, see results in '$OUT_FILE'.\n";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
