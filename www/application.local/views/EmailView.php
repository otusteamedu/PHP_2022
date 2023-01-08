<?php
namespace app\views;

class EmailView {
    public function render (array $errors, string $emails): string {
        $okMessage = ((empty($errors) && $emails) ? 'Все email адреса корректны' : '');
        $errorsMessage = implode("<br />", $errors);

        return '
            <html>
            <head>
                <title></title>
            </head>
            <body>
                <form method="post" action="">
                    <div style="color: darkred">' . $errorsMessage . '</div>
                    <div style="color: green">' . $okMessage . '</div>                    
                    <div>
                        <textarea rows="10" cols="100" name="emails" placeholder="Введите список email">' . htmlspecialchars($emails) . '</textarea>
                    </div>
                    <div>
                        <button type="submit">Проверить</button>
                    </div>
                </form>
            </body>
            </html>
        ';
    }
}
