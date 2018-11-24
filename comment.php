<?php
session_start();
require('dbconnect.php');
//必要な値を取得
$user_id=$_SESSION['47_LearnSNS']['id'];
$feed_id=$_POST['feed_id'];
$comment=$_POST['write_comment'];

// echo '<pre>';
// var_dump($user_id);
// echo '</pre>';

// echo '<pre>';
// var_dump($feed_id);
// echo '</pre>';

// echo '<pre>';
// var_dump($comment);
// echo '</pre>';

// die();
//DBへの保存

$sql='INSERT INTO `comments`(`comment`,`user_id`,`feed_id`,`created`)VALUES(?,?,?,NOW());';
$data=[$comment,$user_id,$feed_id];
$stmt=$dbh->prepare($sql);
$stmt->execute($data);

// 宿題
// タイムライン画面に再遷移
header('Location: timeline.php');
exit();