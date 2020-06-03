<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ネットマルシェ</title>
</head>

<body>
<?php

$gakunen = $_POST['gakunen'];

switch ($gakunen) {
    case '1':
        $kousha = 'あなたの校舎は南校舎です。';
        $bukatsu = '部活動にはスポーツ系と文化系があります。';
        $mokuhyou = 'まずは学校に慣れましょう。';
        break;
    case '2':
        $kousha = 'あなたの校舎は西校舎です。';
        $bukatsu = '都大会目指して全力で取り組みましょう。';
        $mokuhyou = '今しかできないことを見つけよう。';
        break;
    case '3':
        $kousha = 'あなたの校舎は東校舎です。';
        $bukatsu = '引退まで残りわずかです。悔いを残さないようにやり抜こう！';
        $mokuhyou = '将来への道を作ろう。';
        break;
    // どれにも当てはまらなかったら
    default:
        $kousha = 'あなたの校舎は３年生と同じです。';
        $bukatsu = '部活動はありません。';
        $mokuhyou = '早く卒業しましょう。';
        break;
}

print '<br />';
print '校舎　'.$kousha.'<br />';
print '部活　'.$bukatsu.'<br />';
print '目標　'.$mokuhyou.'<br />';

?>
</body>
</html>
