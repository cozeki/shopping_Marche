<?php
//Session対策
if (!isset($_SESSION)) {
    session_start();
}
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません<br />';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}

// 参照画面へ
if (isset($_POST['disp'])==true) {

    if (isset($_POST['staffcode'])==false) {
        header('Location:staff_ng.php');
        exit();
    }
    $staff_code=$_POST['staffcode'];
    header('Location:staff_disp.php?staffcode='.$staff_code);
    exit();
}

// 追加画面へ
if (isset($_POST['add'])==true) {
    header('Location:staff_add.php');
    exit();
}

// 修正画面へ
if (isset($_POST['edit'])==true) {
    // print '修正ボタンが押された';
    if (isset($_POST['staffcode'])==false) {
        header('Location:staff_ng.php');
        exit();
    }
    $staff_code=$_POST['staffcode'];
    header('Location:staff_edit.php?staffcode='.$staff_code);
    exit();
}

// 削除画面へ
if (isset($_POST['delete'])==true) {
    // print '削除ボタンが押された';
    if (isset($_POST['staffcode'])==false) {
        header('Location:staff_ng.php');
        exit();
    }
    $staff_code=$_POST['staffcode'];
    header('Location:staff_delete.php?staffcode='.$staff_code);
    exit();
}
?>