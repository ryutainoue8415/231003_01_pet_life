<?php
session_start();
include("functions.php");
check_session_id();

$user_id = $_SESSION['user_id'];
$pdo = connect_to_db();

$sql = 'SELECT * FROM todo_table LEFT OUTER JOIN (SELECT todo_id, COUNT(id) AS like_count FROM like_table GROUP BY todo_id) AS result_table ON todo_table.id = result_table.todo_id';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  $previewImagePath = "./img/" . $record["fname"];
  $output .= "
    <tr>
      <td>{$record["deadline"]}</td>
      <td>{$record["todo"]}</td>
      <td><img src='{$previewImagePath}' alt='Preview' class='img-thumbnail' style='max-width: 100px;'></td>
      <td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'><i class='fa-solid fa-thumbs-up fa-lg'></i>{$record["like_count"]}</a></td>
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
  <title>記録一覧画面</title>
</head>

<body>
  <div class="card text-center">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active" aria-current="true">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mypage_read.php">Mypage</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="todo_input.php">Create</a>
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
            <th scope="col">日付</th>
            <th scope="col">滞在記録</th>
            <th scope="col">preview</th>
            <th scope="col">like</th>
            <!-- <th scope="col">edit</th>
            <th scope="col">delete</th> -->
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