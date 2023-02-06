<?php
namespace app\views;

class View {
    public function render (): string {
        return '
            <html>
            <head>
                <title></title>
            </head>
            <body>
                <form method="post" action="">               
                    <div>
                        <button type="submit" name="do_action" value="true">Выполнить действие!</button>
                    </div>
                </form>
            </body>
            </html>
        ';
    }
}
