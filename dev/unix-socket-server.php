<?php
if (!is_dir('tmp')) {
    mkdir('tmp');
}
$file = "tmp/unix-test.sock";
echo "Start unix socket server: ", $file, PHP_EOL;
@unlink($file);
$socket = stream_socket_server('unix://' . $file, $errno, $errstr);

while (true) {
    $conn = stream_socket_accept($socket, 60 * 60);
    $data = fgets($conn);
    echo $data;
    if (empty(trim($data))) {
        break;
    }

    fwrite($conn, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n123");

    fclose($conn);
}


fclose($socket);
