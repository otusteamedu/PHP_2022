<?php
namespace app\views;

class View {
    public function render (array $errors, string $dateFrom, string $dateTo, string $email): string {
        $okMessage = ((empty($errors) && $dateFrom && $dateTo && $email) ? 'Заявка на выписку отправлена.' : '');
        $errorsMessage = implode("<br />", $errors);

        return '
            <html>
            <head>
                <title></title>
            </head>
            <body>
                <form method="post" action="">
                    <h3>Запрос на формирование выписки</h3>
                    <div style="color: darkred">' . $errorsMessage . '</div>
                    <div style="color: green">' . $okMessage . '</div>     
                    <div>С <input type="date" name="dateFrom" value="'.$dateFrom.'" /> По <input type="date" name="dateTo" value="'.$dateTo.'" /> Email <input type="email" name="email" value="'.$email.'"></div>   
                    <br/>            
                    <div>
                        <button type="submit">Отправить</button>
                    </div>
                </form>
            </body>
            </html>
        ';
    }
}
