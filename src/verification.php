<?php
require_once('connect_to_bd.php');
require_once('query_bd.php');
require_once('session.php');
$user = '';
$code = '';
$id = '';
if ($_SESSION == [] && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $code = $_GET['code'];
    $sql = "SELECT * FROM `user` WHERE user.code = '$code'";
    $user = getInfo($link, $sql);
    $id = $user[0]['userID'];
}
?>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<div class='passwd'>
    <? if (empty($user[0]['code']) || $user[0]['verification'] == 1) : ?>
        <p class="autorization">Error</p>
    <? else : ?>
        <? $sql = "UPDATE `user` SET `verifycation` = 1, `code` = 'none' WHERE `user`.`userID` = '$id'"; ?>
        <? insertInfo($link, $sql); ?>
        <? header('Location: http://opg-chat.zzz.com.ua/SingIN.php'); ?>
    <? endif; ?>
</div>