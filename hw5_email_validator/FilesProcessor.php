<?php

require_once("EmailValidator.php");

class FilesProcessor {

    private $IN_FILE = "emails.txt";
    private $OUT_FILE = "valid_emails.txt";

    /**
     * @param string $IN_FILE
     * @return array
     */
    public function readFile(string $IN_FILE): array {

        $fp = fopen($IN_FILE, "r");
        if (!$fp) {
            return [];
        }

        $data = [];
        while (($buffer = fgets($fp, 4096)) !== false) {
            $data[] = trim($buffer);
        }

        if (!feof($fp)) {
            return [];
        }

        fclose($fp);

        return $data;
    }

    /**
     * @param string $OUT_FILE
     * @param array $data
     * @return bool
     */
    public function writeFile(string $OUT_FILE, array $data): bool
    {
        $fp = fopen($OUT_FILE, "w");
        if (!$fp) {
            return false;
        }

        foreach ($data as $row) {
            fwrite($fp, $row . "\n");
        }

        fclose($fp);

        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    public function processFileData(array $data): array
    {
        $validator = new EmailValidator();
        $data = $validator->filterEmailsList($data);

        return $data;
    }
}


