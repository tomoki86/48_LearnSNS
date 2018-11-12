<?php
session_start();
require('dbconnect.php');

// エラーを格納する配列
$errors=[];


if (!empty($_POST)){
    $email=$_POST['input_email'];
    $password=$_POST['input_password']; 
    if($email==''){
        $errors['email']='blank';}
    if($password==''){
        $errors['password']='blank';
    }
    if (empty($errors)){

    // バリデーション通過時の処理
    // 1,DBからレコードを取得
        // 宿題
        // セレクト文を考えてくる
        // ただしパスワードは使わない
        $sql='SELECT *FROM`users`WHERE`email`=?';
        $data=[$email];
        $stml=$dbh->prepare($sql);
        $stml->execute($data);
        // DBカラ取得した値を$recordに入れる
        // $recordには連想配列が入ってくる
        // 値がない場合はfalseが入る
        $record=$stml->fetch(PDO::FETCH_ASSOC);
        echo '<pre>';
        var_dump($record);
        echo'</pre>';
        // メールアドレスでの本人確認
        if($record==false){
            $errors['signin']='failed';
        }
        // 2パスワードが一致するか確認
        if(password_verify($password,$record['password'])){
        // 3パスワードが一致したらサインイン処理
        // セッションにユーザーIDのID追加
            $_SESSION['47_LearnSNS']['id']=$record['id'];
            header('Location: timeline.php');
            exit();
            echo'認証成功！';
        }else{
            //認証失敗
            $errors['signin']='failed';
        }
    }
    
}

?>
<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">サインイン</h2>
                <?php if(isset($errors['signin']) && $errors['signin']== 'failed'):?>
                            <p class ="text-danger"> サインインに失敗しました</p>
                        <?php endif ;?>
                <form method="POST" action="signin.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com"
                        <?php if(isset($errors['email']) && $errors['email']== 'blank'):?>>
                            <p class ="text-danger"> Emailアドレスを入力してください</p>
                        <?php endif ;?>
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                        <?php if(isset($errors['password']) && $errors['password']== 'blank'):?>
                            <p class ="text-danger">passwordを入力してください</p>
                        <?php endif ;?>
                    </div>
                    <input type="submit" class="btn btn-info" value="サインイン">
                    <span style="float: right; padding-top: 6px;">
                        <a href="index.php">戻る</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
</body>
<?php include('layouts/header.php'); ?>
</html>
