<?php

  require "db.php";

  session_start();

  //ログイン状態チェック
  if(!isset($_SESSION['NAME'])){
    //ログインしていなかったらリダイレクト
    header("Location: logout.php");
    exit;
  }

  //DB接続
  try{
    $dbh = dbConnect();
    $sql = 'SELECT photo_name FROM ym_photo';
    $data = array();
    $stmt = queryPost($dbh, $sql, $data);

    //画像ファイル名全てを配列に格納
    $files = array();
    while($contents = $stmt->fetch(PDO::FETCH_ASSOC)){
      foreach($contents as $content){
        array_push($files, $content);
      }
    }

    var_dump($files);


  }catch(Exception $e){
    err_msg("画像名書き出し", $e);
  }
 ?>


<!DOCTYPE=html>
<html>
<head>
  <meta charset="UTF-8">
  <title>画像選択</title>
</head>
<body>
  <font face=serif>
    <h1>画像選択画面</h1>
    <label for="select_photo">あなたの文章につける画像を選んでください。</label>
    <br>
    <form action="post_lit.php" method="POST">
      <div>
      <?php  //画像表示 ... HTMLの中に組み込み、サイズやレイアウトを指定する。

      /*
      2/7
      次回はここにHTMLフォームを作り、画像をボタンにしたフォームを作成。
      HMTL内で画像表示の繰り返しをするorその代替法を調べ、実践すべし。
      */

      //画像の数だけ表示
      for($i = 0; $i < count($files); $i++){

        echo $i; //デバッグ用

        //ファイル名を取得
        $file = htmlspecialchars($files[$i]);
        //echo $file;

        //ボタン名を作成
        $name_button = 'button_'.htmlspecialchars($i);
        $name_hidden = 'hidden_'.htmlspecialchars($i);
        ?>

        <!--画像を使ったボタンを表示-->
        <input type="image" src="<?php echo $file;?>" name="<?php echo $name_button;?>" alt="画像">

        <!--画像ボタンが押されたらファイル名を送信する-->
        <input type="hidden" id="photo" name="photo" value="<?php echo $file;?>">
        <!--あとで画像の並べ方などをしらべ、実装すること！2/8-->


        <?php
        //MIMEタイプの取得
        /*
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($img_file);

        header('Content-Type: '.$mime_type);

        //画像表示
        readfile($file);
        */
      }
    ?>
    </div>
    </form>
    <br>
  </font>
</body>
</html>
