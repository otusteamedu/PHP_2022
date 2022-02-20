<?php

namespace KonstantinDmitrienko\StringValidator\App;

use KonstantinDmitrienko\StringValidator\StringValidator\StringValidator;

class App
{
    public function showInputField(): void
    {
        echo <<<HTML
            <form action="" method="post">
                <div style="display: flex;">
                    <label for="string">Fill a string</label>
                    <textarea id="string" name="string" cols="50" rows="5" style="margin-left: 10px;"></textarea>
                </div>
                <button type="submit">Validate</button>
            </form>
HTML;
    }

    public function getPost(): bool
    {
        return isset($_POST['string']);
    }

    public function validateString(): void
    {
        $string = $_POST['string'];

        if (empty($string)) {
            http_response_code(400);
            echo "Error: Required \"string\" parameter is empty.";
            return;
        }

        http_response_code(200);
        if (StringValidator::hasMatchedBrackets($string)) {
            echo "Success: String is valid.";
        } else {
            echo "Error: Your string is invalid.";
        }
    }
}
