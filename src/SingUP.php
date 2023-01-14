<?
require_once('connect_to_bd.php');
require_once('query_bd.php');
require_once('session.php');

$error = '';
$nickname = '';
$passwd = '';
$email = '';
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
$code = substr(str_shuffle($permitted_chars), 0, 10);
$message = "Link: http://opg-chat.zzz.com.ua/verification.php?code=" . $code;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];
    $passwd = $_POST['passwd'];
    $passwd2 = $_POST['passwd2'];
    $email = $_POST['email'];
    $sql = "SELECT * FROM user WHERE user.name = '$nickname'";
    $array = getInfo($link, $sql);
    if (!empty($array[0]['name'])) {
        $error = 'Nickname already taken';
    }
    if (strlen($passwd) < 6)
        $error = 'Password less than 6 characters';
    if (strlen($passwd) > 20)
        $error = 'Password must be less than 20 characters';
    if ($nickname === '' || $passwd === '')
        $error = 'Fill in all fields';
    if ($passwd != $passwd2)
        $error = 'Password mismatch :(';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $error = 'mail entered incorrectly';
    $url = 'https://google.com/recaptcha/api/siteverify';
    $key = '6LcI7CweAAAAAKOeZnSM86hePNwtiipPRetQvhIB';
    $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents($query));
    if($data->success == false)
        $error = 'recaptcha entered incorrectly';
    $hash = password_hash($passwd, PASSWORD_BCRYPT);
    $sql = "SELECT * FROM `user` WHERE user.email = '$email'";
    $array = getInfo($link, $sql);
    if (!empty($array[0]['name'])) {
        $error = 'This mail is already in use.';
    }
    $sql = "INSERT INTO user(name, passwd, email, verifycation, code) VALUES ('$nickname','$hash','$email','0','$code')";
}
?>
<? if($_SESSION == []): ?>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<div class='passwd'>
    <form method='post' id='chat-passwd'>
        <input type="text" class="autorization" name="nickname" placeholder='Enter nickname' value=<?=$nickname?>><br>
        <input type="text" class="autorization" name="email" placeholder='Enter email' value=<?=$email?>><br>
        <input type="password" class="autorization" name="passwd" placeholder='Enter password' value=<?=$passwd?>><br>
        <input type="password" class="autorization" name="passwd2" placeholder='Repeat password'><br><br>
        <div class="g-recaptcha" data-sitekey="6LcI7CweAAAAAGL3iMnhtR8gah-XDoDP_RLo9yW0"></div><br>
        <button>Send</button><br>
        <p class="autorization">Уже имеется аккаунт ? </p><br><a href="http://opg-chat.zzz.com.ua/SingIN.php" class="autorization">Войти</a>
    </form>
    <? if ($error === '' && $_SERVER['REQUEST_METHOD'] === 'POST') : ?>
        <? mail($email, 'Verification email', $message); ?>
        <? insertInfo($link, $sql); ?>
        <p class="autorization"> Ссылка для подтверждения email отправлена! </p>
    <? else : ?>
        <p class="autorization"><?= $error ?> </p>
    <? endif; ?>
</div>
<? else: ?>
    <? header('Location: http://opg-chat.zzz.com.ua') ?>
<? endif; ?>