<?php
  require "db.php";

  try{
    /*
    $dbh = dbConnect();
    $sql = 'DROP TABLE ym_user';
    $data = null;

    $stmt = queryPost($dbh, $sql, $data);
    */

    //デバッグ
    $dbh = dbConnect();
    $sql = 'SHOW TABLES FROM tb210814db';
    $data = null;
    $stmt = $dbh->query($sql);

    while($re = $stmt->fetch(PDO::FETCH_ASSOC)){
      var_dump($re);
    }

  }catch(Exception $e){
    echo "エラー発生";
  }

 ?>
