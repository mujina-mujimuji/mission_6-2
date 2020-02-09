<?php

 session_start();

 //ログイン状態チェック
 if(!isset($_SESSION['NAME'])){
   //ログインしていなかったらリダイレクト
   header("Location: logout.php");
   exit;
 }
 ?>

<!DOCTYPE=html>
<html>
<head>
  <meta charset="UTF-8">
  <title>画像投稿</title>
</head>
<body>
  <font face=serif>
  <h1>画像投稿画面</h1>
  <form action="post_photo_2.php" method="POST" enctype="multipart/form-data">
    <p>目の癒しになる植物の画像を投稿しましょう。</p>
    <br>
    <input type="file" name="photo">
    <br>
    <input type="submit" name="button" value="投稿">
  </form>
</font>
</body>
</html>
