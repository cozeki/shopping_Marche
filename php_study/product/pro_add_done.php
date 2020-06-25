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
    require_once('../common/common.php');

    $post = sanitize($_POST);
    $pro_name = $post['name'];
    $pro_price = $post['price'];
    $pro_gazou_name = $post['gazou_name'];

    // $pro_name = htmlspecialchars($pro_name, ENT_QUOTES, 'UTF-8');
    // $pro_price = htmlspecialchars($pro_price, ENT_QUOTES, 'UTF-8');

    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    // これだとエラーになる
    // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO mst_products(name,price,gazou) VALUES (?,?,?)';
    $stmt = $dbh -> prepare($sql);
    $data[] = $pro_name;
    $data[] = $pro_price;
    $data[] = $pro_gazou_name;
    $stmt->execute($data);

    $dbh = null;

    print $pro_name;
    print 'を追加しました。<br />';
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<a href="pro_list.php">戻る</a>

</body>
</html>
