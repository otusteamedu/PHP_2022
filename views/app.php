<? foreach ($emails as $email => $status):?>
    <?php echo $email ?> - <?php echo $status ? 'correct': 'incorrect'?> </br>
<? endforeach;?>
_____________________________________</br>
