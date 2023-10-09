<?php
session_start();
include('functions.php');

$user_id = $_POST['user_id'];
$password = $_POST['password'];

$pdo = connect_to_db();

$sql = 'SELECT * FROM user_table WHERE user_id=:user_id AND password=:password AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  echo "<p>ログイン情報に誤りがあります</p>";
  echo "<a href=todo_login.php>ログイン</a>";
  exit();
} else {
  $_SESSION = array();
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['session_id'] = session_id();
  $_SESSION['is_admin'] = $user['is_admin'];
  $_SESSION['user_id'] = $user['user_id'];
  header("Location:dashboard_read.php");
  exit();
}
