<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "帳號或密碼錯誤";
            header("Location: ../login.php");
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "登入失敗：" . $e->getMessage();
        header("Location: ../login.php");
        exit();
    }
}

header("Location: ../login.php");
exit(); 