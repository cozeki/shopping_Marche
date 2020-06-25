<?php
//Session対策
session_start();
$_SESSION=array();

if (isset($_COOKIE[session_name()]) == true) {
    setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ネットマルシェ</title>
</head>

<body>
    カートを空にしました。<br />
</body>
</html>
