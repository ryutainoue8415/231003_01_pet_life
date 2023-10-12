<?php
session_start();
include("functions.php");
check_session_id();

// データベースに接続
$pdo = connect_to_db();

// 'user_table' テーブルから 'user_id' カラムの値を取得
$sql = 'SELECT user_id FROM user_table';

$stmt = $pdo->query($sql);

// フォームの選択肢として表示するための配列を初期化
$options = [];

// 取得した値を配列に格納
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $options[] = $row['user_id'];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>記録作成画面</title>
  <style>
    #preview {
      max-width: 100%;
      height: auto;
    }
  </style>
</head>

<body>
  <div class="card text-center">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link" href="admin_dashboard_read.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="admin_todo_input.php">Admin_Create</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_pr_read.php">User_Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_pr_input.php">Profile_Create</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Logout</a>
        </li>
      </ul>
    </div>
    <h1 class="fs-3 text-center mt-5">Create</h1>
    <div class="col-md-6 col-lg-4 mx-auto mt-3" style="background-color: #e0ebeb;">
      <div class="d-grid gap-4 col-8 mx-auto">
        <!-- post -->
        <form action="admin_todo_create.php" method="POST" enctype="multipart/form-data">
          <fieldset>
            <div>
              <select class="form-select mb-2 mt-5" aria-label="user_id" name="user_id">
                <?php
                // 選択肢を表示
                foreach ($options as $option) {
                  echo '<option value="' . $option . '">' . $option . '</option>';
                }
                ?>
              </select>
            </div>
            <div>
              <input type="text" class="form-control mb-2 mt-3" placeholder="滞在記録" name="todo">
            </div>
            <div>
              <input type="date" class="form-control mb-2 mt-3" placeholder="日付" name="deadline">
            </div>
            <div class="mb-3">
              <input type="file" class="form-control mb-2 mt-3" id="formFile" accept="image/*" name="fname" onchange="previewFile(this)">
            </div>
            <p><i class="fa-solid fa-camera fa-xl"></i>preview</p>
            <img id="preview" class="img-fluid">
            <div>
              <button class="btn btn-primary mt-3 mb-5" type="submit">Submit</button>
            </div>
          </fieldset>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script>
          function previewFile(thumbnail) {
            var fileData = new FileReader();
            fileData.onload = (function() {
              //id属性が付与されているimgタグのsrc属性に、fileReaderで取得した値の結果を入力することで
              //プレビュー表示している
              document.getElementById('preview').src = fileData.result;
            });
            fileData.readAsDataURL(thumbnail.files[0]);
          }
        </script>
</body>

</html>