<?php
session_start();
include("functions.php");
check_session_id();

// POSTデータの受信とチェック
if (
    !isset($_POST['user_name']) || $_POST['user_name'] === '' ||
    !isset($_POST['address']) || $_POST['address'] === '' ||
    !isset($_POST['tel']) || $_POST['tel'] === '' ||
    !isset($_POST['pet1_name']) || $_POST['pet1_name'] === '' ||
    !isset($_POST['pet1_kind']) || $_POST['pet1_kind'] === '' ||
    !isset($_FILES['pet1_img_name']['name']) || $_FILES['pet1_img_name']['name'] === '' ||
    !isset($_POST['pet1_vaccine']) || $_POST['pet1_vaccine'] === '' ||
    !isset($_POST['pet1_vac_day']) || $_POST['pet1_vac_day'] === '' ||
    !isset($_POST['pet1_food']) || $_POST['pet1_food'] === '' 
) {
    exit('paramError');
}
$user_id = $_SESSION['user_id'];
$user_name = $_POST['user_name'];
$address = $_POST['address'];
$tel = $_POST['tel'];
$pet1_name = $_POST['pet1_name'];
$pet1_kind = $_POST['pet1_kind'];
$pet1_img_name = $_FILES['pet1_img_name']['name'];
$pet1_vaccine = $_POST['pet1_vaccine'];
$pet1_vac_day = $_POST['pet1_vac_day'];
$pet1_food = $_POST['pet1_food'];

// 画像アップロード先のパス
$upload_dir = "./img/";
$upload_path = $upload_dir . $pet1_img_name;

// アップロードした画像を移動
if (move_uploaded_file($_FILES['pet1_img_name']['tmp_name'], $upload_path)) {
    // データベースへの接続
    $pdo = connect_to_db();

    // データ登録SQL作成
    $sql = 'INSERT INTO user_profile(id, user_id, user_name, address, tel, pet1_name, pet1_kind, pet1_img_name, pet1_vaccine, pet1_vac_day, pet1_food, created_at, updated_at) VALUES(NULL, :user_id, :user_name, :address, :tel,:pet1_name,:pet1_kind,:pet1_img_name,:pet1_vaccine,:pet1_vac_day,:pet1_food, now(), now())';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindValue(':pet1_name', $pet1_name, PDO::PARAM_STR);
    $stmt->bindValue(':pet1_kind', $pet1_kind, PDO::PARAM_STR);
    $stmt->bindValue(':pet1_img_name', $pet1_img_name, PDO::PARAM_STR);
    $stmt->bindValue(':pet1_vaccine', $pet1_vaccine, PDO::PARAM_STR);
    $stmt->bindValue(':pet1_vac_day', $pet1_vac_day, PDO::PARAM_STR);
    $stmt->bindValue(':pet1_food', $pet1_food, PDO::PARAM_STR);

    // データ登録SQL実行
    $status = $stmt->execute();

    // データ登録処理後のリダイレクト
    if ($status) {
        header("Location: user_pr_read.php");
        exit();
    } else {
        // エラーがあればエラーメッセージを表示
        $error = $stmt->errorInfo();
        exit("QueryError:".$error[2]);
    }
} else {
    // アップロードに失敗した場合のエラーメッセージを表示
    echo "Upload failed";
    echo $_FILES['pet1_img_name']['error'];
}
