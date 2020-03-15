<?php
//DB接続-------------------------------------------------

  function dbConnect(){
    $dsn = 'mysql:dbname=tb210814db;host=localhost;charset=utf8';
    $username = 'tb-210814';
    $password = '******'; //伏字にしているので注意
    $options = array(
      // SQL実行時に失敗をスルー
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // デフォルトフェッチモードを連想配列形式に設定
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      // バッファードクエリ（一度に結果すべてを取得し、サーバ負担を軽減)
      // SELECTで得た結果に対してもrowCountメソッドを使えるようにしろ
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );

    $dbh = new PDO ($dsn, $username, $password, $options);
    return $dbh;
  }

  function queryPost($dbh, $sql, $data){

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

 // エラー表示用関数
  function err_msg($place, $e){
    echo "エラー発生@".$place.$e->getMessage();
  }



 ?>
