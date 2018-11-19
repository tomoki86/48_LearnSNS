<?php
require('dbconnect.php');
// 1どの投稿を削除するか
$feed_id =$_GET['feed_id'];
//$_GETでGET送信の値を受け取る

// echo'<pre>';
// var_dump($feed_id);
// echo'</pre>';
// die();
// delete処理
$sql='DELETE FROM`feeds`WHERE`id`=?';
$data=[$feed_id];
$stmt=$dbh->prepare($sql);
$stmt->execute($data);
// timelinephp
header("Location: timeline.php");
exit();