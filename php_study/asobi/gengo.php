<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ネットマルシェ</title>
</head>

<body>
<?php
// 関数ファイルをインクルード
require_once('../common/common.php');

$seireki = $_POST['seireki'];

$wareki = gengo($seireki);
print $wareki;

?>
</body>
</html>
