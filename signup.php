<?php


  require 'password.php';
  require 'db.php';

  //セッション開始
  session_start();

  //エラーメッセージ、新規登録メッセージの初期化
  $errorMessage = "";
  $signupMessage = "";

  //登録ボタンが押された場合
  if(isset($_POST['signup'])){
    //ペンネームのチェック
    if(empty($_POST['u_name'])){  //値がからの時
      $errorMessage = "ペンネームを考えましょう。";
    }elseif(empty($_POST['pass'])){
      $errorMessage = "合言葉を考えましょう。";
    }elseif(empty($_POST['pass_2'])){
      $errorMessage = "合言葉を確かめましょう。";
    }

    if(!empty($_POST['u_name']) && !empty($_POST['pass']) && !empty($_POST['pass_2']) && $_POST['pass'] === $_POST['pass_2']){
      //入力したペンネームと合言葉を格納
      $username = $_POST['u_name'];
      $password = $_POST['pass'];

      //認証
      try{
        //DB接続
        $dbh = dbConnect();
        $sql = 'INSERT INTO ym_user(name, passwd) VALUES (:username, :password)';
        //パスワードはハッシュ化して格納
        $data = array(':username' => $username, ':password' => password_hash($password, PASSWORD_DEFAULT));

        $stmt = queryPost($dbh, $sql, $data);

        //DB側で登録されたidを変数に入れる
        $userid = $dbh->lastinsertid();

        //ログイン時に使用するIDとパスワードを表示
        $signupMessage = '登録が完了しました。あなたの登録番号は'.$userid.'、合言葉は'.$password.'です。';

      }catch(Exception $e){
        err_msg("認証", $e);
      }

    }elseif($_POST['pass'] != $_POST['pass_2']){
      $errorMessage = "合言葉が間違っています。";
    }

  }
 ?>

 <!DOCTYPE=html>
 <html>
 <head>
   <meta charset="UTF-8">
   <title>新規登録</title>
 </head>
 <body>
   <form id="LoginForm" name="LoginForm" action="" method="POST">
     <fieldset>
       <legend>新規登録フォーム</legend>
       <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
       <div><font color="#000000"><?php echo htmlspecialchars($signupMessage, ENT_QUOTES); ?></font></div>
       <label for="username">ペンネーム</label>
       <input type="text" id="u_name" name="u_name" placeholder="ペンネームを入力" value="<?php if(!empty($_POST["u_name"])){echo htmlspecialchars($_POST["u_name"], ENT_QUOTES);}?>">
       <br/>
       <label for="password">合言葉</label>
       <input type="password" id="pass" name="pass" value="" placeholder="合言葉を入力">
       <br/>
       <label for="password2">合言葉(確認用)</label>
       <input type="text" id="pass_2" name="pass_2" value="" placeholder="合言葉を再度入力">
       <br/>
       <input type="submit" id="signup" name="signup" value="新規登録">
     </fieldset>
   </form>
   <br/>
   <form action="login.php">
     <input type="submit" value="戻る">
   </form>
 </body>
 </html>
