<?php
//Session対策
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません<br />';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['staff_name'];
    print 'さんログイン中<br />';
    print '<br />';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ネットマルシェ</title>
</head>
<body>
<?php
try {
    // サニタイズ処理共通化
    require_once('../common/common.php');
    
    $post = sanitize($_POST);
    $staff_name = $post['name'];
    $staff_pass = $post['pass'];

    // $staff_name = htmlspecialchars($staff_name, ENT_QUOTES, 'UTF-8');
    // $staff_pass = htmlspecialchars($staff_pass, ENT_QUOTES, 'UTF-8');

    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    // これだとエラーになる
    // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO mst_staff(name,password) VALUES (?,?)';
    $stmt = $dbh -> prepare($sql);
    $data[] = $staff_name;
    $data[] = $staff_pass;
    $stmt->execute($data);

    $dbh = null;

    print $staff_name;
    print 'さんを追加しました。<br />';
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<a href="staff_list.php">戻る</a>

</body>
</html>
