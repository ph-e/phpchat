<?php
require_once('session.php');
require_once('connect_to_bd.php');
require_once('query_bd.php');
?>

<? if ($_SESSION != []) : ?>
    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="jquery.js" type="text/javascript"></script>
        <script src="jsShow.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                
                var $to = $('#messages');
                $('html, div').animate({
                    scrollTop: 3500,
                }, 1000, 'swing');
            });
        </script>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    </head>
    <header>
        <nav role="navigation">
            <ul>
                <li><a><?=$_SESSION['name']?></a>

                    <ul>
                        <li class="first"><a href="http://opg-chat.zzz.com.ua/change.php">Change password</a></li>
                        <li class="last"><a href="http://opg-chat.zzz.com.ua/Exit.php">Exit</a></li>
                    </ul>

                </li>
            </ul>
        </nav><br>
    </header>

    <body>
        <div class='chat'>
            <div class='history'><a href="http://opg-chat.zzz.com.ua/history.php" id="history" class="history_link">История чата</a></div>
            <div class='chat-messages'>
                <div class='chat-messages__content' id='messages'>
                </div>
            </div>
            <div class='chat-input'>
                <form method='post' id='chat-form'>
                    <input type='text' id='message-text' name="msg" class='chat-form__input' placeholder='Enter your message'> <input type='submit' id="" class='chat-form__submit' value='→'>
                </form>
                <? if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                    <?
                    $id = $_SESSION['userID'];
                    $message = $_POST['msg'];
                    $message = htmlspecialchars($message);
                    $message = trim($message);
                    $message = addslashes($message);
                    if ($message != '') {
                        $sql = "INSERT INTO `message`(`user_id`, `message`) VALUES ('$id','$message')";
                        insertInfo($link, $sql);
                    }
                    ?>
                <? endif; ?>
            </div>
        </div>
    </body>

</html>
<? else : ?>
    <? header('Location: http://opg-chat.zzz.com.ua/SingIN.php') ?>
<? endif; ?>