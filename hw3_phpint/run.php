<?php

/**
 * Create BIG csb file with random data inside
 * @see readme.md
 */

class FakeCsv {

    private $LIMIT = 1E5;

    /**
     * @return string
     */
    function generatePhone()
    {
        $ret = "";
        for($i = 0; $i < 9; $i++) {
            $ret .= strval(rand(0, 9));
        }

        return $ret;
    }

    /**
     * @return string
     */
    function generateName()
    {
        $ret    = "";
        $chars  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $len    = strlen($chars);

        for($i = 0; $i < rand(5, 15); $i++) {
            $pos  = rand(0, $len);
            $ret .= substr($chars, $pos, 1);
        }

        return $ret;
    }

    /**
     * Create CSV file
     * @param string $filename
     * @return int
     */
    function createFakeCsv(string $filename) : int {
        @unlink($filename);
        $handle = fopen($filename, "a");
        $num    = 1;
        for($i = 0; $i < $this->LIMIT; $i++) {
            $phone  = $this->generatePhone();
            $name   = $this->generateName();
            $city   = $this->generateName();
            fwrite($handle, "$num;$phone;$name;$city" . "\n");
            $num++;
        }
        fclose($handle);
        return ($num - 1);
    }
}

echo "[ START CREATING CSV ... ]\n";
$fake = new FakeCsv();
$res = $fake->createFakeCsv("import.csv");
echo "[ File with $res lines created ]\n";
echo "[ DONE ]\n";

