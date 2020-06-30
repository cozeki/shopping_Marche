<?php

function gengo($seireki)
{
    if (1868 <= $seireki && $seireki <= 1911) {
        $gengo = '明治';
    }
    if (1912 <= $seireki && $seireki <= 1925) {
        $gengo = '大正';
    }
    if (1926 <= $seireki && $seireki <= 1988) {
        $gengo = '昭和';
    }
    if (1989 <= $seireki && $seireki <= 2018) {
        $gengo = '平成';
    }
    if (2019 <= $seireki) {
        $gengo = '令和';
    }
    return $gengo;
}

// サニタイズ処理
function sanitize($before)
{
    foreach ($before as $key => $value) {
        $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $after;
}

// 数字チェック
function numberCheck($input)
{
    if (preg_match('/[0-9]/', $input)) {
        return true;
    } else {
        return false;
    }
}
// メールアドレスチェック
function emailCheck($input)
{
    if (preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $input)) {
        return true;
    } else {
        return false;
    }
}
// 電話番号チェック
function telCheck($input)
{
    if (preg_match('/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/', $input)) {
        return true;
    } else {
        return false;
    }
}
?>