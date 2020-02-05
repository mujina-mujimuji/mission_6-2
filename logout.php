<?php

  session_start();

  if(isset($_SESSION['NAME'])){
    $errorMessage = "ログアウトしました。";
  } else {
    $errorMessage = "セッションがタイムアウトしました。";
  }


  //セッションの変数のクリア
  $_SESSION = array();

  //セッションのクリア
  @session_destroy();
 ?>

<!DOCTYPE=html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ログアウト</title>
</head>
<body>
  <font face=serif>
  <h1>ログアウト画面</h1>
  <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
  <ul>
    <li><a href="login.php">ログイン画面に戻る</a></li>
    <li><a href="main.php">メイン画面に戻る</a></li>
  </ul>
  </font>
</body>
</html>
