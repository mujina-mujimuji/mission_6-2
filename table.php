<?php
  //DB管理ファイルの呼び出し
  require "db.php";


  //ユーザ管理用テーブルの作成(番号:自動決定、ユーザ名、パスワード)
  try{
    $dbh = dbConnect();

    //テーブル内容の決定
    $sql_user = 'CREATE TABLE ym_user(
      id INT(11) AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(20),
      passwd VARCHAR(100)
    ) engine=innodb default charset=utf8';

    $res = $dbh->query($sql_user);

    //デバッグ
    $check = $dbh->query('SHOW TABLES FROM tb210814db');

  }catch(Exception $e){
    err_msg("ユーザテーブル作成", $e);
  }

  //画像管理用テーブルの作成(番号:自動決定、画像ファイル名)
  try{
    $dbh = dbConnect();

    //テーブル内容の決定
    $sql_photo = 'CREATE TABLE ym_photo(
      id INT(11) AUTO_INCREMENT PRIMARY KEY,
      photo_name VARCHAR(100)
    ) engine=innodb default charset=utf8';

    $res = $dbh->query($sql_photo);

    //デバッグ
    $check = $dbh->query('SHOW TABLES FROM tb210814db');

  }catch(Exception $e){
    err_msg("画像テーブル作成", $e);
  }

  //最終投稿管理用テーブル(番号、名前、タイトル、文章、画像ファイル名)
  try{
    $dbh = dbConnect();

    //テーブル内容の決定
    $sql_post = 'CREATE TABLE ym_post(
      id INT(11) AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(20),
      title VARCHAR(50),
      comment VARCHAR(400),
      photo_name VARCHAR(100)
    ) engine=innodb default charset=utf8';

    $res = $dbh->query($sql_post);

    //デバッグ
    $check = $dbh->query('SHOW TABLES FROM tb210814db');

  }catch(Exception $e){
    err_msg("投稿テーブル作成", $e);
  }


 ?>
