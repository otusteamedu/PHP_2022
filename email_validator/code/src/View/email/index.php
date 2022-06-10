<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h3>Email validator</h3>
<form method="POST" action="email">
    <textarea name="email" cols="30" rows="10"><?php echo ($stringWithEmails) ?? $stringWithEmails; ?></textarea>
    <input type="submit" value="check">
</form>

<?php if (isset($data['validEmails']) && !empty($data['validEmails'])) { ?>
    <h4>Следующие почтовые адреса являются валидными:</h4>
    <ol>
        <?php foreach ($data['validEmails'] as $validEmail): ?>
            <li><?= $validEmail->email; ?></li>
        <?php endforeach; ?>
    </ol>
<?php } else { ?>
    <h4>Валидных почтовых адресов нет.</h4>
<?php } ?>
</body>
</html>
