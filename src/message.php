<?php

function save($message)
{
    require_once('connect_to_bd.php');
    require_once('query_bd.php');
    require_once('session.php');
    if ($_SESSION != []) {
        $id = $_SESSION['userID'];
        $message = htmlspecialchars($message);
        $message = trim($message);
        $message = addslashes($message);
        $sql = "INSERT INTO `message`(`user_id`, `message`) VALUES ('$id','$message')";
        insertInfo($link, $sql);
    }
}
