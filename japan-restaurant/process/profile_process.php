<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $phone = $_POST['phone'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];

    try {
        // 先檢查欄位是否存在
        $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'phone'");
        $exists = $stmt->fetch();

        if (!$exists) {
            // 如果欄位不存在，則新增
            $pdo->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(20)");
        }

        // 開始交易
        $pdo->beginTransaction();

        // 基本資料更新（包含電話）
        $sql = "UPDATE users SET email = ?, phone = ?";
        $params = [$email, $phone];

        // 如果有輸入新密碼
        if (!empty($new_password)) {
            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "兩次密碼輸入不一致";
                header("Location: ../profile.php");
                exit;
            }
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql .= ", password = ?";
            $params[] = $hashed_password;
        }

        $sql .= " WHERE id = ?";
        $params[] = $user_id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // 提交交易
        $pdo->commit();

        $_SESSION['success'] = "資料更新成功！";
    } catch (PDOException $e) {
        // 發生錯誤時回滾交易
        $pdo->rollBack();
        $_SESSION['error'] = "更新失敗：" . $e->getMessage() .
            "\n SQL: " . $sql .
            "\n Params: " . print_r($params, true);
    }

    header("Location: ../profile.php");
    exit;
}

header("Location: ../profile.php");
exit();