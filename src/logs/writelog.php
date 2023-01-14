<?php
define('FILE_NAME','logs/log.txt');
function saveLog(string $date, string $name) : void {
    $ip = $_SERVER['REMOTE_ADDR'];
    $log = "'date' => $date, 'name' => $name, 'ip' => $ip \n";
    file_put_contents(FILE_NAME,$log,FILE_APPEND);
}
?>