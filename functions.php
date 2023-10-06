<?php

function connect_to_db()
{
  $dbn = 'mysql:dbname=pet_life;charset=utf8mb4;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';

 // さくらサーバー用
 //$dbn = 'mysql:dbname=mysql57.browngoat99.sakura.ne.jp;charset=utf8mb4;port=3306;host=browngoat99_gs_sotsusei';
 //$user = 'browngoat99';
 //$pwd = 'pbnyH+9Higgj';


  // ローカル動作確認用
  //$dbn = 'mysql:dbname=pet_life;charset=utf8mb4;port=3306;host=localhost';
  //$user = 'root';
  //$pwd = '';
  

  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}

function check_session_id()
{
  if (
    !isset($_SESSION["session_id"]) ||
    $_SESSION["session_id"] != session_id()
  ) {
    header("Location:todo_login.php");
  } else {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
  }
}
