<?php
//Session対策
if (!isset($_SESSION)) {
    session_start();
}
session_regenerate_id(true);
if (!isset($_SESSION['member_login'])) {
    print 'ようこそゲスト様　';
    print '<a href="member_login.html">会員ログイン</a><br />';
    print '<br />';
} else {
    print 'ようこそ';
    print $_SESSION['member_name'];
    print '様　';
    print '<a href="member_logout.php">ログアウト</a><br />';
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
    $pro_code = $_GET['procode'];

    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
        $kazu = $_SESSION['kazu'];
        if (in_array($pro_code, $cart) == true) {
            print 'その商品はすでにカートに入っています。<br />';
            print '<a href="shop_list.php">商品一覧に戻る</a>';
            exit();
        }
    }
    $cart[] = $pro_code;
    $kazu[] = 1;
    $_SESSION['cart'] = $cart;
    $_SESSION['kazu'] = $kazu;

    foreach ($cart as $key => $val) {
        print '<br />';
        print $val;
        print '<br />';
    }
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

カートに追加しました。<br />
<br />
<a href="shop_list.php">商品一覧に戻る</a>

</body>
</html>