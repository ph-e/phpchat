<?php
require_once('session.php');
require_once('connect_to_bd.php');
require_once('query_bd.php');
require_once('smile.php');

$sql = "SELECT * FROM `message` WHERE messageID > (SELECT MAX(messageID) FROM `message`) - 30";
$data = getInfo($link, $sql);

if($_SESSION != []){
    foreach ($data as $value) {
        $sql = "SELECT * FROM `user` WHERE `userID` = $value[user_id]";
        $dataUs = getInfo($link, $sql);
        $name = $dataUs[0]['name'];
        $msg = $value['message'];
        $msg = wordwrap($msg,44,'<br />');//если строка больше, чем место в чате, то делим её(что бы не было горизонтального скролла)
        $msg = preg_replace('"\b(https?://\S+)"', '<a href="$1" class="chat__link">$1</a>', $msg);
        $msg = str_replace(getSmile(),getTag(),$msg);
        echo "
        <div id='messages'>
        <b>$name :</b>
        <br>
        $msg
        </div>";
    };
}

else{
    header('Location: http://opg-chat.zzz.com.ua');
}

?>