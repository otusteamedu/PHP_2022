<?php
spl_autoload_register(function($name) {
    $path=explode("\\",$name);
    require 'src/'.end($path).'.php';
});
