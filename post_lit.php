<?php

  session_start();

  if(!isset($_POST["photo"])){
    echo "画像が選択されていないようです。";
  }

  $photo_name = $_POST["photo"];

 ?>

<!DOCTYPE=html>
<html>
<head>
  <meta charset="UTF-8">
  <title>文章投稿フォーム</title>
</head>
<body>
  <font face=serif>
    <h1>文章投稿画面</h1>
    <h2>あなたの選択した画像</h2>
    <img src="<?php echo $photo_name?>" alt="" title="">
    <hr>
    <form action="post_lit_2.php" method="POST">
      <label for="title">題名</label>
      <input type="text" id="title" name="title" placeholder="題名">
      <br>
      <input type="text" id="lit" name="lit" placeholder="短編小説、エッセイ、詩、短歌、俳句など、400字以内で創作してみましょう。">
      <!-- このフォームの成形の仕方を調べること 2/8 -->
      <br>
      <input type="submit" value="投稿">
      <input type="hidden" name="photo" value="<?php echo $photo_name; ?>">
    </form>
  </font>
</body>
</html>
