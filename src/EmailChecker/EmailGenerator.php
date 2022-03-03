<?php

namespace Queen\App\EmailChecker;

use Faker\Factory;

class EmailGenerator {

    /**
     * @param int $qty
     *
     * @return array
     */
    public function generateEmail(int $qty = 10)
    {
        $faker = Factory::create();

        $emails = [];
        for ($i = 0; $i < $qty; $i++) {
            $emails[] =  $faker->email() . PHP_EOL;
        }
        
        return $emails;
    }

    /**
     * @return false|int
     */
    public function writeEmails()
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . $_ENV['EMAIL_LIST_FILE'];
        $emails  = $this->generateEmail();

        return file_put_contents($file, $emails, FILE_APPEND | LOCK_EX);
    }
}
