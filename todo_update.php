<?php
session_start();
include("functions.php");
check_session_id();

if (
  !isset($_POST['todo']) || $_POST['todo'] === '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] === '' ||
  !isset($_FILES['fname']['name']) || $_FILES['fname']['name'] === '' ||
  !isset($_POST['id']) || $_POST['id'] === ''
) {
  exit('paramError');
}

$todo = $_POST["todo"];
$deadline = $_POST["deadline"];
$fname = $_FILES['fname']['name'];
$id = $_POST["id"];

// 画像アップロード先のパス
$upload_dir = "./img/";
$upload_path = $upload_dir . $fname;

// アップロードした画像を移動
if (move_uploaded_file($_FILES['fname']['tmp_name'], $upload_path)) {
  $error = error_get_last();
  echo "Upload failed: " . $error['message'];

  // データベースへの接続
  $pdo = connect_to_db();

$sql = "UPDATE todo_table SET todo=:todo, deadline=:deadline, fname=:fname, updated_at=now() WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
  $stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:dashboard_read.php");
exit();
}