<?php
session_start();

include("functions.php");
check_session_id();

$id = $_GET["id"];

$pdo = connect_to_db();

$sql = 'SELECT * FROM user_profile WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <title>DB連携型todoリスト（編集画面）</title>
</head>

<body>
  <div class="card text-center">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link" href="dashboard_read.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mypage_read.php">Mypage</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user_pr_read.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="true">Edit</a>
        </li>

      </ul>
    </div>
    <h1 class="fs-3 text-center mt-5">Edit</h1>
    <div class="col-md-6 col-lg-4 mx-auto mt-3" style="background-color: #e0ebeb;">
      <div class="d-grid gap-4 col-8 mx-auto">
        <!-- post -->
        <form action="todo_update.php" method="POST" enctype="multipart/form-data">
          <fieldset>
            <div>
              <input type="text" class="form-control mb-2 mt-5" name="user_name" value="<?= $record["user_name"] ?>">
            </div>
            <div>
              <input type="text" class="form-control mb-2 mt-3" name="address" value="<?= $record["address"] ?>">
            </div>
            <div>
              <input type="text" class="form-control mb-2 mt-3" name="tel" value="<?= $record["tel"] ?>">
            </div>
            <div>
              <input type="text" class="form-control mb-2 mt-3" name="pet1_name" value="<?= $record["pet1_name"] ?>">
            </div>
            <div>
              <input type="text" class="form-control mb-2 mt-3" name="pet1_kind" value="<?= $record["pet1_kind"] ?>">
            </div>
            <div>
              <input type="file" class="form-control mb-2 mt-3" id="formFile" accept="image/*" name="pet1_img_name" onchange="previewFile(this)" src="<?= "./img/" . $record["pet1_img_name"] ?>">
            </div>
            <p><i class="fa-solid fa-camera fa-xl"></i>preview</p>
            <img id="preview" class="img-fluid" src="<?= "./img/" . $record["pet1_img_name"] ?>">
            <div>
              <div>
                <select class="form-select mb-2 mt-3" name="pet1_vaccine" value="<?= $record["pet1_vaccine"] ?>">
                  <option selected>接種ワクチン</option>
                  <option value="犬_5種混合">犬_5種混合</option>
                  <option value="犬_6種混合">犬_6種混合</option>
                  <option value="犬_7種混合">犬_7種混合</option>
                  <option value="犬_8種混合">犬_8種混合</option>
                  <option value="犬_9種混合">犬_9種混合</option>
                  <option value="猫_3種混合">猫_3種混合</option>
                  <option value="猫_4種混合">猫_4種混合</option>
                  <option value="猫_5種混合">猫_5種混合</option>
                </select>
              </div>
              <div>
                <input type="date" class="form-control mb-2 mt-3" name="pet1_vac_day" value="<?= $record["pet1_vac_day"] ?>">
              </div>
              <div>
                <input type="text" class="form-control mb-2 mt-3" name="pet1_food" value="<?= $record["pet1_food"] ?>">
              </div>
              <button class="btn btn-primary mt-3 mb-5" type="submit">Submit</button>
            </div>
            <input type="hidden" name="id" value="<?= $record["id"] ?>">
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