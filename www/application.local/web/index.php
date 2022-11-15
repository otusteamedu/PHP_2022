<?php

use app\models\EmailForm;

require __DIR__.'/../vendor/autoload.php';

$errors = [];
$emails = !empty($_POST['emails']) ? htmlspecialchars($_POST['emails']) : null;

if ($emails) {
    $form = new EmailForm($_POST['emails']);
    if (!$form->validate()) {
        $errors = $form->getErrors();
    }
}

?>

<html>
<head>
    <title></title>
</head>
<body>
    <form method="post" action="">
        <div style="color: darkred"><?=implode('<br />', $errors)?></div>
        <?php if(empty($errors) && $emails): ?>
            <div style="color: green">Все email адреса корректны.</div>
        <?php endif; ?>
        <div>
            <textarea rows="10" cols="100" name="emails" placeholder="Введите список email"><?=$emails?></textarea>
        </div>
        <div>
            <button type="submit">Проверить</button>
        </div>

    </form>
</body>
</html>
