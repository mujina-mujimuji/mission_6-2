<?php

  require "db.php";
  session_start();

  //エラーメッセージを初期化
  $errorMessage = "";
  //「戻る」用のリンクを初期化
  $link = "";

  //エラー処理
  if(!isset($_POST['title']) || empty($_POST['lit'])){ //無題でもいいようにissetを使用

    $errorMessage = "題名、あるいは投稿が未入力です。";
    $link = "post_lit.php";

  }elseif(isset($_POST['title']) && !empty($_POST['lit'])){

    //タイトル、文章の受け取り
    $title = $_POST["title"];
    $lit = $_POST["lit"];
    $name = $_SESSION['NAME'];
    $photo_name = $_POST["photo"];

    try{
      $dbh = dbConnect();

      //投稿用テーブルym_postにペンネーム、題名、内容、画像名を保存
      $sql = 'INSERT INTO ym_post(name, title, comment, photo_name)
              VALUES(:name, :title, :lit, :photo_name)';
      $data = array(":name" => $name, ":title" => $title, ":lit" => $lit, ":photo_name" => $photo_name);
      $stmt = queryPost($dbh, $sql, $data);

      //デバッグ
      echo "----------投稿フォームデバッグ----------"."<br>";
      $sql = 'SELECT * FROM ym_post';
      $data = array();
      $stmt = queryPost($dbh, $sql, $data);

      while($contents = $stmt->fetch(PDO::FETCH_ASSOC)){
        var_dump($contents);
        /*
        foreach($contents as $content){
          echo $content." ";
        }
        */
        echo "<br>";
      }
      echo "<br>"."-----------------------------------------"."<br>";

      $errorMessage = "投稿が完了しました。";
      $link = "main.php";

    }catch(Exception $e){

      //エラー処理
      err_msg("投稿処理", $e);
      $errorMessage = "投稿が失敗しました。";
      $link = "post_lit.php";

      exit;
    }
  }
 ?>

 <!DOCTYPE=html>
 <html>
 <head>
   <meta charset="UTF-8">
   <title>投稿処理</title>
 </head>
 <body>
   <font face=serif>
     <h1>投稿内容の確認</h1>
     <p><?php if(!empty($errorMessage)){echo htmlspecialchars($errorMessage, ENT_QUOTES);}?></p>
     <br>
     <div>
       <label for="photo">あなたの選んだ写真:</label>
       <img src="<?php echo $photo_name; ?>" alt="" title="">
       <br>
     </div>
     <div>
       <label for="title">題名:</label>
       <p><?php echo $title; ?></p>
     </div>
     <div>
       <label for="lit">本文:</label>
       <br>
       <p><?php echo $lit; ?></p>
     </div>
     <div>
       <label for="name">ペンネーム:</label>
       <p><?php echo $name; ?></p>
     </div>
     <br>
     <ul>
       <li><a href="<?php echo $link; ?>">戻る</a></li>
     </ul>
   </font>
 </body>
 </html>
