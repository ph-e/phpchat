<?php
require_once('session.php');
if($_SESSION != []){
    $_SESSION = [];
    session_destroy();
    header('Location: http://opg-chat.zzz.com.ua');
}
?>