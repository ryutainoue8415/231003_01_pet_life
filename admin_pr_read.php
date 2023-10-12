<?php
session_start();
include("functions.php");
check_session_id();

// セッションからユーザーIDを取得
$user_id = $_SESSION['user_id'];

// データベースに接続
$pdo = connect_to_db();

// SQLクエリを準備
// $sql = 'SELECT * FROM user_profile WHERE user_profile.user_id = :user_id';
$sql = 'SELECT * FROM user_profile';

// SQLクエリを実行するためのステートメントを準備
$stmt = $pdo->prepare($sql);

// ユーザーIDをバインド
// $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt = $pdo->prepare($sql);

try {
  // SQLクエリを実行
  $status = $stmt->execute();
} catch (PDOException $e) {
  // エラーが発生した場合はエラーメッセージをJSON形式で出力して終了
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQLクエリの結果を取得
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";

// 結果をHTMLテーブルの形式に整形
foreach ($result as $record) {
  $previewImagePath = "./img/" . $record["pet1_img_name"];
  $output .= "
    <tr>
      <td>{$record["user_name"]}</td>
      <td>{$record["address"]}</td>
      <td>{$record["tel"]}</td>
      <td>{$record["pet1_name"]}</td>
      <td>{$record["pet1_kind"]}</td>
      <td><img src='{$previewImagePath}' alt='Preview' class='img-thumbnail' style='max-width: 100px;'></td>
      <td>{$record["pet1_vaccine"]}</td>
      <td>{$record["pet1_vac_day"]}</td>
      <td>{$record["pet1_food"]}</td>
      <td>{$record["created_at"]}</td>
      <td>{$record["updated_at"]}</td>
      <td><a href='user_pr_edit.php?id={$record["id"]}'><i class='fa-solid fa-pen-to-square fa-lg'></i></a></td>
      <td><a href='user_pr_delete.php?id={$record["id"]}'><i class='fa-solid fa-trash fa-lg'></i></a></td>
    </tr>
  ";
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>Profile画面</title>
</head>

<body>
  <div class="card text-center">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link" href="admin_dashboard_read.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_todo_input.php">Admin_Create</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="true">User_Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_pr_input.php">Profile_Create</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Logout</a>
        </li>
      </ul>
    </div>
    <fieldset>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">氏名</th>
            <th scope="col">住所</th>
            <th scope="col">TEL</th>
            <th scope="col">pet1_名前</th>
            <th scope="col">pet1_種</th>
            <th scope="col">preview</th>
            <th scope="col">接種ワクチン</th>
            <th scope="col">接種日</th>
            <th scope="col">フード名</th>
            <th scope="col">登録日</th>
            <th scope="col">更新日</th>
            <th scope="col">edit</th>
            <th scope="col">delete</th>
          </tr>
        </thead>
        <tbody>
          <?= $output ?>
        </tbody>
      </table>
    </fieldset>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>