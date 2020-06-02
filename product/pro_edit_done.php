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
    $pro_code = $_POST['code'];
    $pro_name = $_POST['name'];
    $pro_price = $_POST['price'];

    $pro_code   = htmlspecialchars($pro_code, ENT_QUOTES, 'UTF-8');
    $pro_name   = htmlspecialchars($pro_name, ENT_QUOTES, 'UTF-8');
    $pro_price  = htmlspecialchars($pro_price, ENT_QUOTES, 'UTF-8');
    $pro_gazou_name_old = $_POST['gazou_name_old'];
    $pro_gazou_name = $_POST['gazou_name'];


    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    // これだとエラーになる
    // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'UPDATE mst_products SET name=?,price=?,gazou=? WHERE code=?';

    $stmt = $dbh -> prepare($sql);
    $data[] = $pro_name;
    $data[] = $pro_price;
    $data[] = $pro_gazou_name;
    $data[] = $pro_code;


    $stmt->execute($data);

    $dbh = null;
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

if ($pro_gazou_name_old !== $pro_gazou_name) {
    if ($pro_gazou_name_old !='') {
        unlink('./gazou/'.$pro_gazou_name_old);
    }
}
?>

修正しました。<br />
<br />

<a href="pro_list.php">戻る</a>

</body>
</html>
