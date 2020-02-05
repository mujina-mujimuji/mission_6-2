<?php

  require "db.php";

  //パスワードのハッシュ化を行うため
  require "password.php";

  //セッション開始
  session_start();

  //エラーメッセージ初期化
  $errorMessage = "";

  //ログインボタンが押された場合
  if(isset($_POST["login"])){
    //ユーザ名の入力チェック
    if(empty($_POST["userid"])){

      $errorMessage = "登録番号を教えてください。";

    }elseif(empty($_POST["pass"])){

      $errorMessage = "合言葉を入力してください。";
    }

    if(!empty($_POST["userid"]) && !empty($_POST["pass"])){

      //入力したペンネームと合言葉を格納
      $userid = $_POST["userid"];
      $passwd = $_POST["pass"];

      //認証
      try{
        $dbh = dbConnect();
        $sql = 'SELECT * FROM ym_user WHERE id=:userid';
        $data = array(':userid' => $userid);
        $stmt = queryPost($dbh, $sql, $data);
        $contents = $stmt->fetch(PDO::FETCH_ASSOC);

        /*デバッグ用
        var_dump($contents);
        */

        if($row = $contents){   //比較ではなく代入している。ちゃんと代入できたら処理
          if(password_verify($passwd, $row['passwd'])){
            session_regenerate_id(true);

            //入力したidのユーザ名を取得
            $id = $row['id'];
            $sql = "SELECT * FROM ym_user WHERE id=:id";
            $data = array(':id' => $id);
            $stmt = queryPost($dbh, $sql, $data);

            foreach($stmt as $row){
              $row['name'];   //ユーザ名を取得
            }

            $_SESSION['NAME'] = $row['name'];
            header('Location: main.php');   //メイン画面へ移動
            exit();   //処理終了
          } else {
            //認証失敗
            $errorMessage = 'ペンネーム、あるいは合言葉に誤りがあるようです。そんな日もありますね。';
          }

        } else {
          //成功ならセッションIDを新規に発行
          //該当データなし
          $errorMessage = 'ペンネーム、あるいは合言葉に誤りがあるようです。そんな日もありますね。';
        }

      } catch(Exception $e){
        err_msg("ログイン処理", $e);
      }
    }
  }
 ?>

<!DOCTYPE=html>
<html lang="ja">
  <head>
	   <meta charset="utf-8">
	    <title>ログイン</title>
  </head>
  <body>
    <font face=serif>
    <h1>ログイン画面</h1>
    <form id="LoginForm" name="LoginForm" action="" method="POST">
      <fieldset>
        <legend>ログインフォーム</legend>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES);?></font></div>
        <label for="userid">登録番号</label>
        <input type="text" id="userid" name="userid" placeholder="登録番号を入力" value="<?php if(!empty($_POST["userid"])){echo htmlspecialchars($_POST["userid"], ENT_QUOTES);}?>">
        <br/>
        <label for="pass">合言葉</label>
        <input type="text" id="pass" name="pass" value="" placeholder="合言葉を入力">
        <br/>
        <input type="submit" id="login" name="login" value="ログイン">
      </fieldset>
    </form>
    <br/>
    <form action="signup.php">
      <fieldset>
        <legend>新規登録フォーム</legend>
        <input type="submit" value="新規登録">
      </fieldest>
    </form>
  </font>
  </body>
  </html>
