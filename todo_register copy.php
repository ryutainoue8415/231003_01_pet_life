<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <title>ユーザ登録画面</title>
</head>

<body>
  <div class="card text-center">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link" href="index.php">TOP</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="todo_login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="true">Register</a>
        </li>
      </ul>
    </div>
    <h1 class="fs-3 text-center mt-5">Please Register</h1>
    <div class="col-md-6 col-lg-4 mx-auto mt-3" style="background-color: #e0ebeb;">
      <div class="d-grid gap-4 col-8 mx-auto">
        <!-- post -->
        <form action="todo_register_act.php" method="POST">
          <fieldset>
            <div>
              <input type="text" class="form-control mb-2 mt-5" placeholder="email" name="user_id">
            </div>
            <div>
              <input type="text" class="form-control mb-2 mt-3" placeholder="Password" name="password">
            </div>
            <div>
              <button class="btn btn-primary mt-3 mb-5" type="submit">Register</button>
            </div>
          </fieldset>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>