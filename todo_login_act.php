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
  ?>

    <div class="container text-center mt-5">
      <div class="alert alert-danger p-3" role="alert">
        <h4 class="mb-4">ログイン情報に誤りがあります</h4>
        <a href="todo_login.php" class="btn btn-primary btn-lg">ログイン</a>
      </div>
    </div>
  <?php
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
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>