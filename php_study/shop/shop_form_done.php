<?php
//Session対策
if (!isset($_SESSION)) {
    session_start();
}
session_regenerate_id(true);
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

    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal1 = $post['postal1'];
    $postal2 = $post['postal2'];
    $address = $post['address'];
    $tel = $post['tel'];

    print $onamae.'様<br /><br />';
    print 'ご注文ありがとうございました。<br />';
    print $email.'にメールを送りましたのでご確認ください。<br />';
    print '商品は以下の住所に発送させていただきます。<br />';
    print '郵便番号：'.$postal1.'-'.$postal2.'<br />';
    print '住所：'.$address.'<br />';
    print '電話番号：'.$tel.'<br />';

    $honbun = '';
    $honbun.= $onamae."様\n\n このたびはご注文ありがとうございました。\n";
    $honbun.= "\n";
    $honbun.= "ご注文商品\n";
    $honbun.= "------------\n";

    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max = count($cart);

    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    for ($i = 0; $i < $max; $i++) {
        $sql = 'SELECT name,price FROM mst_products WHERE code=?';
        $stmt = $dbh -> prepare($sql);
        $data[0] = $cart[$i];
        $stmt -> execute($data);

        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

        $name = $rec['name'];
        $price = $rec['price'];
        $kakaku[] = $price;
        $suryo = $kazu[$i];
        $shokei = $price * $suryo;

        $honbun.= $name.' ';
        $honbun.= $price.'円 ×';
        $honbun.= $suryo.'個 =';
        $honbun.= $shokei."円\n";
    }

    // テーブルのロック
    $sql = 'LOCK TABLES dat_sales WRITE,dat_sales_product WRITE';
    $stmt = $dbh -> prepare($sql);
    $stmt -> execute();

    $sql = 'INSERT INTO dat_sales(code_member,name,email,postal1,postal2,address,tel) VALUES (?,?,?,?,?,?,?)';
    $stmt = $dbh -> prepare($sql);
    $data = array();
    $data[] = 0;
    $data[] = $onamae;
    $data[] = $email;
    $data[] = $postal1;
    $data[] = $postal2;
    $data[] = $address;
    $data[] = $tel;
    $stmt -> execute($data);

    $sql = 'SELECT LAST_INSERT_ID()';
    $stmt = $dbh -> prepare($sql);
    $stmt -> execute();
    $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    $lastcode = $rec['LAST_INSERT_ID()'];

    for ($i = 0; $i < $max; $i++) {
        $sql = 'INSERT INTO dat_sales_product(code_sales,code_product,price,quantity) VALUES(?,?,?,?)';
        $stmt = $dbh -> prepare($sql);
        $data = array();
        $data[] = $lastcode;
        $data[] = $cart[$i];
        $data[] = $kakaku[$i];
        $data[] = $kazu[$i];
        $stmt -> execute($data);
    }

    // テーブルロック解除
    $sql = 'UNLOCK TABLES';
    $stmt = $dbh -> prepare($sql);
    $stmt -> execute();
    $dbh = null;
    
    $honbun.= "送料は無料です。\n";
    $honbun.= "------------\n";
    $honbun.= "\n";
    $honbun.= "代金は以下の口座にお振込ください。\n";
    $honbun.= "ネットマルシェ　ベジ支店　普通口座　1234567\n";
    $honbun.= "入金確認が取れ次第、梱包、発送させていただきます。\n";
    $honbun.= "\n";
    $honbun.= "□□□□□□□□□□□□□□□□□□□□□□□□□□□□\n";
    $honbun.= "有機野菜のネットマルシェ\n";
    $honbun.= "\n";
    $honbun.= "茨城県石岡市××123−12\n";
    $honbun.= "電話　090-1234-5678\n";
    $honbun.= "メール　marche@google.com\n";
    $honbun.= "□□□□□□□□□□□□□□□□□□□□□□□□□□□□\n";

    // メール本文を画面に出力
    // print '<br />';
    // print nl2br($honbun);

    // お客様にメール送信
    $title = 'ご注文ありがとうございます。';
    $header = 'From:ozeki@freedomland.jp';  // 管理部のメールアドレス
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail($email, $title, $honbun, $header);

    // 管理部門にメール送信
    $title = 'お客様からご注文がありました。';
    $header = 'From:'.$email;  // お客様のメールアドレス
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('Japanese');
    mb_internal_encoding('UTF-8');
    mb_send_mail('ozeki@freedomland.jp', $title, $honbun, $header);   // 管理部のメールアドレス

    // カートを空にする
    require_once('clear_cart.php');
} catch (Exception $e) {
    print '<br />ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

<br />
<a href="shop_list.php">商品画面へ</a>
</body>
</html>
