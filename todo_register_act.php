<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title></title>
  <style>

  </style>
</head>

<body>
  <?php
  
  include('functions.php');

  if (
    !isset($_POST['user_id']) || $_POST['user_id'] === '' ||
    !isset($_POST['user_id']) || $_POST['user_id'] === ''
  ) {
    echo json_encode(["error_msg" => "no input"]);
    exit();
  }

  $user_id = $_POST["user_id"];
  $password = $_POST["password"];

  $pdo = connect_to_db();

  $sql = 'SELECT COUNT(*) FROM user_table WHERE user_id=:user_id';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

  if ($stmt->fetchColumn() > 0) {
    ?>
    <div class="container text-center mt-5"> 
  <div class="alert alert-danger p-3" role="alert"> 
    <h4 class="mb-4">すでに登録されているユーザです．</h4>
    <a href="todo_login.php" class="btn btn-primary btn-lg">Login</a>
  </div>
</div>
    <?php
    exit();
  }

  $sql = 'INSERT INTO user_table(id, user_id, password, is_admin, created_at, updated_at, deleted_at) VALUES(NULL, :user_id, :password, 0, now(), now(), NULL)';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);

  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

  header("Location:todo_login.php");
  exit();
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>