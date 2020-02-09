<?php

  require "db.php";
  session_start();

  $errorMessage = "";
  $link = "";

  //画像がアップロードされているかどうかチェック
  if(strlen($_FILES['photo']['name']) > 0){

    //画像名の受け取り
    $file_name = $_FILES['photo']['tmp_name'];
    $photo_name = $_FILES['photo']['name'];
    echo $photo_name;

    //画像ファイルを保存
    move_uploaded_file($file_name, $photo_name);



    try{
      $dbh = dbConnect();
      $sql = 'INSERT INTO ym_photo(photo_name) VALUES(:name)';
      $data = array(':name' => $photo_name);


      //画像名をDBに格納
      $stmt = queryPost($dbh, $sql, $data);

      //デバッグ 中身をチェック
      $sql = "SELECT * FROM ym_photo";
      $data = array();
      $stmt = queryPost($dbh, $sql, $data);

      echo "----------画像投稿フォームデバッグ----------"."<br>";
      while($parts = $stmt->fetch(PDO::FETCH_ASSOC)){
        foreach($parts as $part){
          echo $part;
        }
        echo "<br>";
      }
      echo "<br>"."-----------------------------------------"."<br>";

      $errorMessage = "画像アップロードが完了しました";
      $link = "main.php";

    } catch(Exception $e){

      //エラー処理
      err_msg("画像投稿処理", $e);

      $errorMessage = "画像の保管が失敗しました";

      exit;
    }
  }else{

    //デバッグ用
    echo "エラー: アップロードの時点で失敗"."<br>";

    $errorMessage = "画像がアップロードされていないようです。";
    $link = "post_photo.php";
  }

 ?>

<!DOCTYPE=html>
<html>
<head>
  <meta charset="UTF-8">
  <title>画像投稿処理</title>
</head>
<body>
  <font face=serif>
    <h1>画像投稿処理画面</h1>
    <p><?php if(!empty($errorMessage)){echo htmlspecialchars($errorMessage, ENT_QUOTES);}?></p>
    <br>
    <ul>
      <li><a href="<?php echo $link ?>">戻る</a></li>
    </ul>
  </font>
</body>
</html>
