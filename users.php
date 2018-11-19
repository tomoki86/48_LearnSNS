<?php
session_start();
require('dbconnect.php');

// echo'<pre>';
// var_dump($_SESSION);
// echo'</pre>';

$sql='SELECT *FROM`users`';
// $data=[$_SESSION['47_LearnSNS']];
$stmt=$dbh->prepare($sql);
$stmt->execute();
$signin_user=$stmt->fetch(PDO::FETCH_ASSOC);

// if(isset($_GET['feed_id'])){
// // getパラメーター取得
// $feed_id =$_GET['feed_id'];
// // SQL文を定義
// $sql='SELECT`f`.*,`u`.`name`,`u`.`img_name`FROM`feeds`AS`f`LEFT JOIN`users`AS`u`ON`f`.`user_id`=`u`.`id`WHERE`f`.`id`=?';
// $data=[$feed_id];
// $stml=$dbh->prepare($sql);
// $stml->execute($data);

// // 投稿情報を一件取得
// $feed=$stml->fetch(PDO::FETCH_ASSOC);

// }

?>
<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
    <?php include('navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php foreach ($signin_user as $user):?>
                <div class="thumbnail">
                    <div class="row">
                        <div class="col-xs-2">
                            <img src="user_profile_img/<?php echo$signin_user['img_name'];?>" width="80px">
                        </div>
                        <div class="col-xs-10">
                            名前 <a href="profile.php" style="color: #7f7f7f;"><?php echo $signin_user['name'];?></a>
                            <br>
                            <?php echo $signin_user['created'];?>からメンバー
                        </div>
                    </div>
                    <div class="row feed_sub">
                        <div class="col-xs-12">
                            <span class="comment_count">つぶやき数：10</span>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>
