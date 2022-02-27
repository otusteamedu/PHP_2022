<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Валидатор скобочек</title>
    <meta name="description" content="Валидатор скобочек">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="modal modal-sheet position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSheet">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-6 shadow">
            <form action="" method="post">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Проверка валидации</h5>
                </div>
                <div class="modal-body py-0">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="text" name="field" class="form-control" aria-describedby="skobko" value="<?=$field;?>">
                        <div id="skobko" class="form-text">Введите скобочкообразность, пример: <strong>)()()((())()()()((()</strong></div>
                    </div>
                </div>
                <div class="modal-footer flex-column border-top-0">
                    <?php if (isset($validation['is_validated'])) { ?>
                        <?php if ($validation['is_validated'] === true) { ?>
                            <p style="color: green"><?php echo $validation['message'] ?></p>
                        <?php } else { ?>
                            <p style="color: red"><?php echo $validation['message'] ?></p>
                        <?php } ?>
                    <?php } ?>
                    <button type="submit" class="btn btn-lg btn-primary w-100 mx-0 mb-2">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

<?php

echo "Current nginx container is: {$_SERVER['HOSTNAME']}<br><br>";

echo 'Session ID is: ' . session_id() . '<br><br>';

echo '<hr><br>Checking of session in the Memcached:';

if ($_SESSION['CODE_TEST']) {
echo 'Value from session: <strong>' . $_SESSION['CODE_TEST'] . '</strong>';
} else {
$_SESSION['CODE_TEST'] = 'some text';
echo 'Value <strong>' . $_SESSION['CODE_TEST'] . '</strong> added in session, you can reload of page.';
}

?>