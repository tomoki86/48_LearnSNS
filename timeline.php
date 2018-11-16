<?php
session_start();



// SQL処理
require('dbconnect.php');
//ログインしてない状態でアクセス禁止
if(!isset($_SESSION['47_LearnSNS']['id'])){
   header('Location:signin.php');
   exit();
}
$sql='SELECT *FROM`users`WHERE`id`=?';
$data=[$_SESSION['47_LearnSNS']['id']];
$stml=$dbh->prepare($sql);
$stml->execute($data);
$signin_user=$stml->fetch(PDO::FETCH_ASSOC);

$errors=[];
if(!empty($_POST)){
  $feed =$_POST['feed'];
  if($feed!=''){
//宿題
    $sql='INSERT INTO`feeds`(`feed`,`user_id`,`created`)VALUES(?,?,NOW());';
    $data= [$feed,$signin_user['id']];
    $stmt=$dbh->prepare($sql);
    $stmt->execute($data);

    header('Location:timeline.php');
    exit();
  }else{
    //バリデーション処理
    $errors['feed']='blank';
  }
}
// 1投稿処理を全て取得
$sql='SELECT `f`.*,`u`.`name`, `u`.`img_name` FROM`feeds`AS `f`LEFT JOIN`users`AS `u`ON`u`.`id`=`f`.`user_id`ORDER BY`f`.`created`DESC';
$stml=$dbh->prepare($sql);
$stml->execute();

// 投稿情報を全て入れる配列定義
$feeds=[];
while(true){
  $record= $stml->fetch(PDO::FETCH_ASSOC);
  if($record==false){
    break;
  }
  $feeds[]=$record;


// echo'<pre>';
// var_dump($feeds);
// echo'</pre>';
}

// FETCH（一つの行を取得すること）

// 宿題
// $feedsをもとにHTML内に
// 投稿内容、投稿日時、ユーザー名、ユーザー画像を表示

    // $_POST['input_password']=$_SESSION['47_LearnSNS']['password'];
//check.phpに遷移しないように
    // $errors['rewirte']=true;




// timeline.phpで定義した

// テーブル結合
// 主キーと外部キーを結合条件に利用して
// 複数のテーブルから一度にデータを取得する

// 外部結合
// SELECT*FROM`テーブル１`LEFT JOIN`テーブル２`ON 条件 (左のデーブルに１のレコード全て表示　右のテーブルに)
// SELECT*FROM`テーブル１`RIGHT JOIN`テーブル２`ON 条件(右のデーブルに１のレコード全て表示　左のテーブルに)

// SELECT*FROM`feeds`LEFT JOIN`users`ON `feeds`.`user_id`=`users`.`id`;

// 内部結合
// SELECT*FROM`テーブル１`JOIN`テーブル２`ON 条件

// JOIN
// ２つのテーブル両方に値がないと取得されない

// 条件結合
// ON条件
// 条件にはどのテーブルとどのテーブルが紐づくかはっきりとさせること　`feeds`.`user_id`=`users`.`id`
// 単に`id`だけではわからない


// カラム一部読み出し
// SELECT
//       `テーブル１`.*,
//       `テーブル２`.`カラム名１`,
//       `テーブル２`.`カラム名２`
// FROM`テーブル１`LEFT JOIN`テーブル２`ON条件

// 投稿全てとユーザの名前、ユーザーの画像名を取得するSQLを考える
// SELECT FROM`feeds`
// LEFT JOIN`users`
// ON `feeds`.`user_id`=`users`.`id`;

// SELECT*FROM`feeds`LEFT JOIN`users`ON `feeds`.`user_id`=`users`.`id`;

// テーブルのリネーム
// テーブル名　AS 省略した名前（任意の名前）<-テーブルを指定する場所
// `feeds` AS `f`

// SELECT `feeds`.*,`users`.`name`, `users`.`img_name` FROM`feeds`LEFT JOIN`users`ON`users`.`id`=`feeds`.`user_id`

// SELECT `f`.*,`u`.`name`, `u`.`img_name` FROM`feeds`AS `f`LEFT JOIN`users`AS `u`ON`u`.`id`=`f`.`user_id`
// テーブルを指定する箇所でASを付与
// カラムを指定する箇所で省略名が利用可能

// 順番の指定
// ORDER BY カラム名
// 指定したカラム名でソートができる
// カラム名の後ろでDESC(降順)ASC（昇順）を指定可能
// 省略可能、省略した場合ASCになる

// SQLの例
// SELECT `f`.*,`u`.`name`, `u`.`img_name` FROM`feeds`AS `f`LEFT JOIN`users`AS `u`ON`u`.`id`=`f`.`user_id`ORDER BY`created` DESC;

// var_dump($_POST)
// die(); 

// ()カッコ
// []ブランケット、スクエアブランケット
// {}カーリー

?>
<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
    <!--
        include(ファイル名);
        指定したファイルを組み込むんで表示
        共通部分を切り出して使いたいページから読み込む
    -->
    <?php include('navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="timeline.php?feed_select=news">新着順</a></li>
                    <li><a href="timeline.php?feed_select=likes">いいね！済み</a></li>
                </ul>
            </div>
            <div class="col-xs-9">
                <div class="feed_form thumbnail">
                    <form method="POST" action="">
                        <div class="form-group">
                            <textarea name="feed" class="form-control" rows="3" placeholder="happy" style="font-size: 24px;"></textarea><br>
                            <?php if(isset($errors['feed']) && $errors['feed']== 'blank'):?>
                            <p class ="text-danger">コメントを入力してください</p>
                            <?php endif ;?>
                        </div>
                        <input type="submit" value="投稿する" class="btn btn-primary">
                    </form>
                </div>
                <?php foreach ($feeds as $feed):
                ?>
                <div class="thumbnail">
                    <div class="row">
                        <div class="col-xs-1">
                            <img src="user_profile_img/<?php echo$feed['img_name'];?>" width="40px">
                        </div>
                        <div class="col-xs-11">
                            <a href="profile.php" style="color: #7f7f7f;"><?php echo $feed['name'];?></a>
                            <?php echo $feed['created'];?>
                        </div>
                    </div>
                    <div class="row feed_content">
                        <div class="col-xs-12">
                            <span style="font-size: 24px;"><?php echo$feed['feed'];?></span>
                        </div>
                    </div>
                    <div class="row feed_sub">
                        <div class="col-xs-12">
                            <button class="btn btn-default">いいね！</button>
                            いいね数：
                            <span class="like-count">10</span>
                            <a href="#collapseComment" data-toggle="collapse" aria-expanded="false"><span>コメントする</span></a>
                            <span class="comment-count">コメント数：5</span>
                            <?php if($signin_user['id']==$feed['user_id']):?>
                                <a href="edit.php?feed_id=<?php echo$feed['id'];?>" class="btn btn-success btn-xs">編集</a>
                                <a onclick="return confirm('ほんとに消すの？');" href="delete.php?feed_id=<?php echo$feed['id'];?>" class="btn btn-danger btn-xs">削除</a>
                                <!-- get送信時はURL?キー＝値 -->
                            <?php endif;?>
                        </div>
                        <?php include('comment_view.php'); ?>
                    </div>
                </div>
                <?php endforeach;?>
                <div aria-label="Page navigation">
                    <ul class="pager">
                        <li class="previous disabled"><a><span aria-hidden="true">&larr;</span> Newer</a></li>
                        <li class="next disabled"><a>Older <span aria-hidden="true">&rarr;</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>
