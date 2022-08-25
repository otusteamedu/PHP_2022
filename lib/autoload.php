<?php
/**
 * @author PozhidaevPro
 * @email pozhidaevpro@gmail.com
 * @Date 25.08.2022 12:21
 */

spl_autoload_register(function ($class_name) {
    $prefix = 'Otus\\';
    $base_dir = __DIR__."/";
    $len = strlen($prefix);
    if (strncmp($prefix, $class_name, $len) !== 0) {
        return;
    }
    $relative_class = substr($class_name, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});