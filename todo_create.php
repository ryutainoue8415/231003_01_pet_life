<?php
session_start();
include("functions.php");
check_session_id();

// POSTデータの受信とチェック
if (
    !isset($_POST['todo']) || $_POST['todo'] === '' ||
    !isset($_POST['deadline']) || $_POST['deadline'] === '' ||
    !isset($_FILES['fname']['name']) || $_FILES['fname']['name'] === ''
) {
    exit('paramError');
}

$todo = $_POST['todo'];
$deadline = $_POST['deadline'];
$fname = $_FILES['fname']['name'];

// 画像アップロード先のパス
$upload_dir = "C:/xampp/htdocs/gs/pet_life/img/";
$upload_path = $upload_dir . $fname;

// アップロードした画像を移動
if (move_uploaded_file($_FILES['fname']['tmp_name'], $upload_path)) {
    // データベースへの接続
    $pdo = connect_to_db();

    // データ登録SQL作成
    $sql = 'INSERT INTO todo_table(id, todo, deadline, fname, created_at, updated_at) VALUES(NULL, :todo, :deadline, :fname, now(), now())';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
    $stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
    $stmt->bindValue(':fname', $fname, PDO::PARAM_STR);

    // データ登録SQL実行
    $status = $stmt->execute();

    // データ登録処理後のリダイレクト
    if ($status) {
        header("Location: todo_input.php");
        exit();
    } else {
        // エラーがあればエラーメッセージを表示
        $error = $stmt->errorInfo();
        exit("QueryError:".$error[2]);
    }
} else {
    // アップロードに失敗した場合のエラーメッセージを表示
    echo "Upload failed";
    echo $_FILES['fname']['error'];
}