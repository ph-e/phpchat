<?php
require_once('connect_to_bd.php');
require_once('query_bd.php');
require_once('session.php');
$error = '';
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
$passwd = substr(str_shuffle($permitted_chars), 0, 10);
$message = '';
if($_SESSION == [] && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $sql = "SELECT * FROM `user` WHERE `user`.`email` = '$email'";
    $usInfo = getInfo($link,$sql);
    if (empty($usInfo[0]['name'])) {
        $error = 'User is not found';
    }
    $name = $usInfo[0]['name'];
    $url = 'https://google.com/recaptcha/api/siteverify';
    $key = '6LcI7CweAAAAAKOeZnSM86hePNwtiipPRetQvhIB';
    $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents($query));
    if($data -> success == false)
        $error = 'recaptcha entered incorrectly';
    $message = "Login: $name password: $passwd";
    $hash = password_hash($passwd, PASSWORD_BCRYPT);
    $sql = "UPDATE `user` SET `passwd` = '$hash' WHERE `user`.`email` = '$email'";
}
?>

<? if ($_SESSION == []) : ?>
    <html>

    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <li><a href="http://opg-chat.zzz.com.ua/SingIN.php" id="back">Back</a></li><br><br><br>
    </head>
    <div class='passwd'>
        <form method='post' id='chat-passwd'>
            <input type="text" class="autorization" name="email" placeholder='Enter email'><br><br>
            <div class="g-recaptcha" data-sitekey="6LcI7CweAAAAAGL3iMnhtR8gah-XDoDP_RLo9yW0"></div><br>
            <button>Send</button><br>
        </form>
        <? if ($error === '' && $_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <? mail($email, 'Account recovery', $message); ?>
            <? insertInfo($link,$sql); ?>
            <p class="autorization">A new password has been sent to your email</p>
        <? else : ?>
            <p class="autorization"><?= $error ?> </p>
        <? endif; ?>
    </div>
<? else : ?>
    <? header('Location: http://opg-chat.zzz.com.ua') ?>
<? endif; ?>	