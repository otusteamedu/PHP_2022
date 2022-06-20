<?php
/** @var $check
 * @var $email
 */
?>
<form id="form" method="get">
    <input type="text" id="email"/>
    <input type="submit" value="Отправить"/>
</form>

<?php

if ($email) {
    echo "<h3>$email : $check</h3> ";
}

?>
