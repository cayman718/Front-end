<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // 驗證
    if (strlen($username) < 3 || strlen($username) > 20) {
        $_SESSION['error'] = "用戶名長度必須在3-20個字符之間";
        header("Location: ../register.php");
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "請輸入有效的電子郵件地址";
        header("Location: ../register.php");
        exit();
    }
    
    if (strlen($password) < 6) {
        $_SESSION['error'] = "密碼長度必須至少為6個字符";
        header("Location: ../register.php");
        exit();
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "兩次輸入的密碼不一致";
        header("Location: ../register.php");
        exit();
    }
    
    try {
        // 檢查用戶名是否已存在
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = "此用戶名已被使用";
            header("Location: ../register.php");
            exit();
        }
        
        // 檢查電子郵件是否已存在
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = "此電子郵件已被使用";
            header("Location: ../register.php");
            exit();
        }
        
        // 密碼加密並創建用戶
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashed_password]);
        
        $_SESSION['success'] = "註冊成功！請登入";
        header("Location: ../login.php");
        exit();
        
    } catch(PDOException $e) {
        $_SESSION['error'] = "註冊失敗：" . $e->getMessage();
        header("Location: ../register.php");
        exit();
    }
}

header("Location: ../register.php");
exit();