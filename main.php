<?php
  require 'db.php';

  session_start();

  //ログイン状態チェック

  if(isset($_SESSION['NAME'])) {  //改変前は if(!isset...)
    //header("Location: logout.php"); //ログインしていなかったらリダイレクト
    $errorMessage = "ログアウト";
    $link = "logout.php";
    //exit;
  } elseif(!isset($_SESSION['NAME'])){
    $errorMessage = "ログイン";
    $link = "login.php";
  }


  try{
    $dbh = dbConnect();
    $sql = 'SELECT id FROM ym_post';
    $data = array();

    $stmt = queryPost($dbh, $sql, $data);

    $all_num = array();

    //id全てを配列に格納
    while($contents = $stmt->fetch(PDO::FETCH_ASSOC)){
      foreach($contents as $content){
        array_push($all_num, $content);
      }
    }

    //デバッグ
    //var_dump($all_num);



  }catch(Exception $e){
    err_msg("最大id取得", $e);
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
      <li><a href="<?php echo $link;?>"><?php if(!empty($errorMessage)){echo htmlspecialchars($errorMessage, ENT_QUOTES);}?></a></li>
      <li><a href="post_photo.php">画像投稿</a></li>
      <li><a href="select_photo.php">文章投稿</a></li>
    </ul>
    <br>
    <div>
      <?php  //表示機能
        //id一覧の中から無作為に3つ選出
        $rand_nums = array_rand($all_num, 3);

        foreach($rand_nums as $id){
          try{
            $dbh = dbConnect();
            $sql = 'SELECT name, title, comment, photo_name FROM ym_post WHERE id=:id';
            $data = array(":id" => $id);

            $stmt = queryPost($dbh, $sql, $data);

            //投稿の要素を配列に格納
            while($contents = $stmt->fetch(PDO::FETCH_ASSOC)){


              //デバッグ
              //var_dump($contents);

              //各要素を変数に格納
              $name = $contents['name'];
              $title = $contents['title'];
              $comment = $contents['comment'];
              $photo = $contents['photo_name'];
              ?>

              <!--CSSを用いて配置を工夫する事！-->
              <div>
              <p>
                <img style="float: left; margin-top: 30px; margin-bottom: 30px; margin-left: 50px; margin-right: 50px;" src="<?php echo htmlspecialchars($photo)?>" width="300">
                  <b><?php echo htmlspecialchars($title)?></b>
                  <br>
                  <?php echo htmlspecialchars($comment)?>
                  <br>
                  <i>––<?php echo htmlspecialchars($name)?></i>
                <br>
              </p>
              </div>
          <?php
            }
          }catch(Exception $e){
            err_msg("表示", $e);
          }
        }

       ?>
    </div>
    </font>
  </body>
</html>
