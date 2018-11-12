<?php
session_start();
//1 セッションを空にする
//セッション変数の破棄（ブラウザ内
$_SESSION =[];
// サーバー内のセッション変数のクリア（サーバー内
session_destroy();

//2サインイン画面に遷移する
header("Location: signin.php");
exit();
