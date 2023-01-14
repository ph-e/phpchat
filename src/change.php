<?
require_once('session.php');
require_once('connect_to_bd.php');
require_once('query_bd.php');

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION != []){
    $id = $_SESSION['userID'];
    $pass = $_POST['passwd'];
    $pass2 = $_POST['passwd2'];
    if($pass != $pass2)
        $error = 'Wrong password';
    if(strlen($pass) < 6)
        $error = 'Password less than 6 characters';
    if(strlen($pass) > 20)
        $error = 'Password must be less than 20 characters';
    $url = 'https://google.com/recaptcha/api/siteverify';
    $key = '6LcI7CweAAAAAKOeZnSM86hePNwtiipPRetQvhIB';
    $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents($query));
    if($data -> success == false)
        $error = 'recaptcha entered incorrectly';
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    $sql = "UPDATE `user` SET `passwd` = '$hash' WHERE `user`.`userID` = '$id'";
}
?>

<? if ($_SESSION != []) : ?>
    <html>

    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <li><a href="http://opg-chat.zzz.com.ua/index.php" id="back">Back</a></li><br><br><br>
    </head>
    <div class='passwd'>
        <form method='post' id='chat-passwd'>
            <input type="password" class="autorization" name="passwd" placeholder='Enter password'><br>
            <input type="password" class="autorization" name="passwd2" placeholder='Repead password'><br><br><br>
            <div class="g-recaptcha" data-sitekey="6LcI7CweAAAAAGL3iMnhtR8gah-XDoDP_RLo9yW0"></div><br>
            <button>Send</button><br>
        </form>
        <? if ($error == '' && $_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <? insertInfo($link,$sql); ?>
            <p class="autorization">Password changed</p>
        <? else : ?>
            <p class="autorization"><?= $error ?> </p>
        <? endif; ?>
    </div>
<? else : ?>
    <? header('Location: http://opg-chat.zzz.com.ua') ?>
<? endif; ?>