<?php
  require 'db.php';

  session_start();

  //ログイン状態チェック

  if(isset($_SESSION['NAME'])) {  //改変前は if(!isset...)
    //header("Location: Logout.php"); //ログインしていなかったらリダイレクト
    $message = "ログアウト";
    $link = "logout.php";
    //exit;
  } elseif(!isset($_SESSION['NAME'])){
    $message = "ログイン";
    $link = "login.php";
  }

?>

<!DOCTYPE=html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>メイン</title>
  </head>
  <body>
    <font face=serif>
    <h1>メイン画面</h1>
    <!-- ユーザIDにHTMLタグが含まれても良いようにエスケープする -->
    <p>ようこそ<?php if(!empty($_SESSION['NAME'])){echo htmlspecialchars($_SESSION['NAME']."さん", ENT_QUOTES);} ?></p>
    <ul>
      <li><a href="<?php echo $link;?>"><?php if(!empty($message)){echo htmlspecialchars($message, ENT_QUOTES);}?></a></li>
    </ul>
    </font>
  </body>
</html>
