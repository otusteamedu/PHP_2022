<?php
//declare(strict_types=1);
//
//$file = "php-socket-chat.sock";
//$socketFile = __DIR__ . '/' . $file;
//
//@unlink($file); // clear socket-file
//
//function logIt(string $text) {
//    file_put_contents('server.txt', date('Y-m-d H:i:s') . ' ' . $text . PHP_EOL, FILE_APPEND | LOCK_EX);
//}
//
//logIt('start server');
//
//if (!extension_loaded('sockets')) {
//    logIt('The sockets extension is not loaded');
//    die('The sockets extension is not loaded.');
//}
//
//// https://www.php.net/manual/en/function.socket-create.php
//$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
//
//if ($socket === false) {
//    logIt('Unable to create AF_UNIX socket');
//    die('Unable to create AF_UNIX socket');
//}
//
//if (!socket_bind($socket, $socketFile)) {
//    logIt("Unable to bind to $socketFile");
//    die("Unable to bind to $socketFile");
//}
//
//while(1) // server never exits
//{
//// receive query
//    if (!socket_set_block($socket))
//        die('Unable to set blocking mode for socket');
//    $buf = '';
//    $from = '';
//    echo "Ready to receive...\n";
//// will block to wait client query
//    $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
//    if ($bytes_received == -1)
//        die('An error occured while receiving from the socket');
//    echo "Received $buf from $from\n";
//
//    $buf .= "->Response"; // process client query here
//
//// send response
//    if (!socket_set_nonblock($socket))
//        die('Unable to set nonblocking mode for socket');
//// client side socket filename is known from client request: $from
//    $len = strlen($buf);
//    $bytes_sent = socket_sendto($socket, $buf, $len, 0, $from);
//    if ($bytes_sent == -1)
//        die('An error occured while sending to the socket');
//    else if ($bytes_sent != $len)
//        die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
//    echo "Request processed\n";
//}

$file = "myserver.sock";

@unlink($file);
$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
if (socket_bind($socket, $file) === false) {
    echo "Не удалось задать адресс сокету" . PHP_EOL;
    die();
}
$result = socket_listen($socket);
if (!$result) {
    echo "Не удалось подключиться к сокету" . PHP_EOL;
    die();
}
echo "Ожидание сообщений (Для выхода нажмите CTRL+C)..." . PHP_EOL;
while (true) {
    $connection = socket_accept($socket);
    if (!$connection) {
        echo "Не удалось подключиться к сокету" . PHP_EOL;
        die();
    }
    $input = socket_read($connection, 1024);
    $client = $input;
    echo $client . PHP_EOL;
    socket_close($connection);
}