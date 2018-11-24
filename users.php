<?php
session_start();
require('dbconnect.php');

// echo'<pre>';
// var_dump($_SESSION);
// echo'</pre>';

$sql='SELECT *FROM`users`where`id`=?';
$data=[$_SESSION['47_LearnSNS']['id']];
$stmt=$dbh->prepare($sql);
$stmt->execute($data);
$signin_user=$stmt->fetch(PDO::FETCH_ASSOC);

$sql='SELECT*FROM`users`';
$stmt=$dbh->prepare($sql);
$stmt->execute();;
$users=[];
while(true){
    $record=$stmt->fetch(PDO::FETCH_ASSOC);
if ($record==false){
    break;
    }
// 各ユーザーのつぶやき数を取得
$feed_sql = 'SELECT COUNT(*) AS `cnt` FROM `feeds` WHERE `user_id` = ?';
$feed_data = [$record['id']];
$feed_stmt = $dbh->prepare($feed_sql);
$feed_stmt->execute($feed_data);
$feed = $feed_stmt->fetch(PDO::FETCH_ASSOC);
$record['feed_cnt'] = $feed['cnt'];

$users[]=$record;
}

// echo '<pre>';
// var_dump($users);
// echo '</pre>';
$sq
?>
<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
    <?php include('navbar.php'); ?>
    <div class="container">
        <?php foreach ($users as $user):?>
        <div class="row">
            <div class="col-xs-12">
                <div class="thumbnail">
                    <div class="row">
                        <div class="col-xs-2">
                            <img src="user_profile_img/<?php echo$user['img_name'];?>" width="80px">
                        </div>
                        <div class="col-xs-10">
                            名前 <a href="profile.php" style="color: #7f7f7f;"><?php echo $user['name'];?></a>
                            <br>
                            <?php echo $user['created'];?>からメンバー
                        </div>
                    </div>
                    <div class="row feed_sub">
                        <div class="col-xs-12">
                            <span class="comment_count">つぶやき数：<?php echo $user['feed_cnt']?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>
