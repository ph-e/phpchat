<?php
require_once('connect_to_bd.php');
require_once('query_bd.php');
require_once('session.php');
$error = '';
$nickname = '';
$passwd = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwd = $_POST['passwd'];
    $nickname = $_POST['nickname'];
    $sql = "SELECT * FROM `user` WHERE `user`.`name` = '$nickname'";
    $array = getInfo($link, $sql);
    if (empty($array[0]['userID']))
        $error = 'User nor found';
    else {
        if ($array[0]['code'] != 'none')
            $error = 'Email not confirmed';
        if (!password_verify($passwd, $array[0]['passwd']))
            $error = 'Wrong password';
    }
}
?>
<? if($_SESSION == []): ?>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>
<div class='passwd'>
    <form method='post' id='chat-passwd'>
        <input type="text" class="autorization" name="nickname" placeholder='Enter nickname' value=<?=$nickname?>><br>
        <input type="password" class="autorization" name="passwd" placeholder='Enter password' value=<?=$passwd?>><br>
        <button>Send</button><br>
        <p class="autorization">Не зарегистрированы ? </p><br><a href="http://opg-chat.zzz.com.ua/SingUP.php" class="autorization">Создать аккаунт</a><br>
        <a href="http://opg-chat.zzz.com.ua/recovery.php" class="autorization">Забыли пароль?</a>
    </form>
    <? if($error === '' && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <? $_SESSION = $array[0] ?>
        <? header('Location: http://opg-chat.zzz.com.ua/authorization.php') ?>
    <? else : ?>
        <p class="autorization"><?= $error ?> </p>
    <? endif; ?>
</div>
<? else: ?>
    <? header('Location: http://opg-chat.zzz.com.ua/') ?>
<? endif; ?>