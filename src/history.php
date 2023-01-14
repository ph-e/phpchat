<?php
require_once('session.php');
require_once('connect_to_bd.php');
require_once('query_bd.php');
require_once('smile.php');
$sql = "SELECT * FROM `message`";
$data = getInfo($link, $sql);
?>

<? if ($_SESSION != []) : ?>
    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <header>
        <div class='head'>
            <a href="#" id="user" class="nav_link"><?= $_SESSION['name']; ?></a>
        </div>
    </header>

    <body>
        <div class='chat'>
            <div class='back'><a href="http://opg-chat.zzz.com.ua" id="history" class="history_link">Назад</a></div>
            <div class='chat-messages'>
                <div class='chat-messages__content' id='messages'>
                    <? 
                    foreach ($data as $value) {
                        $sql = "SELECT * FROM `user` WHERE `userID` = $value[user_id]";
                        $dataUs = getInfo($link, $sql);
                        $name = $dataUs[0]['name'];
                        $msg = $value['message'];
                        $msg = wordwrap($msg, 44, '<br />'); //если строка больше, чем место в чате, то делим её(что бы не было горизонтального скролла)
                        $msg = str_replace(getSmile(),getTag(),$msg);
                        echo "
	                    <div id='messages'>
	                    <b>$name :</b>
	                    <br>
	                    $msg
	                    </div>";
                    };

                    ?>
                </div>
            </div>
        </div>
    </body>

    </html>
<? else : ?>
    <? header('Location: http://opg-chat.zzz.com.ua/SingIN.php') ?>
<? endif; ?>