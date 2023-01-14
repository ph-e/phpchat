<?
define('BD_NAME','localhost');
define('TB_NAME','eduardd901');
$link = mysqli_connect(BD_NAME,'eduardd901','AnTiNooB121212db',TB_NAME,3306);

if(mysqli_connect_errno())
        exit(mysqli_connect_error() . "<br>" . 'GG');
?>