<?php

use KonstantinDmitrienko\EmailValidator\Email\Email;
use KonstantinDmitrienko\EmailValidator\File\File;

require 'vendor/autoload.php';

$emails = File::getLinesFromFile('emails.txt');

$validEmails = Email::validateEmails($emails);

File::putLinesInFile($validEmails, 'valid-emails.txt');
