<?php
require_once('logs/writelog.php');
require_once('session.php');
if($_SESSION != []){
    $date = date('Y-d-m H:i:s');
    saveLog($date,$_SESSION['name']);
    header('Location: http://opg-chat.zzz.com.ua/index.php');

}
else{
    header('Location: http://opg-chat.zzz.com.ua/SingIN.php');
}
