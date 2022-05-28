<?php
/** @var $check
 * @var $email
 */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<form>
    <input type="text" class="email"/>
    <input type="submit" value="Отправить"/>
</form>

<h3><?= $email!=''?$email.' - ':'' ?>  <?= $check ?></h3>

<script>
    $('form').submit(function (e) {
        e.preventDefault();
        window.location = window.location.origin + '?email=' + $(e.target).find('input.email').val();
    })
</script>
