<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    $_SESSION['error'] = "請先登入";
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $people_count = $_POST['people_count'];
    $special_request = trim($_POST['special_request']);
    
    // 基本驗證
    if (strtotime($reservation_date) < strtotime(date('Y-m-d'))) {
        $_SESSION['error'] = "無法預約過去的日期";
        header("Location: ../reservation.php");
        exit();
    }
    
    try {
        // 檢查該時段是否已滿（假設每個時段最多10桌）
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations 
                              WHERE reservation_date = ? 
                              AND reservation_time = ? 
                              AND status != 'cancelled'");
        $stmt->execute([$reservation_date, $reservation_time]);
        $existing_reservations = $stmt->fetchColumn();
        
        if ($existing_reservations >= 10) {
            $_SESSION['error'] = "抱歉，該時段訂位已滿";
            header("Location: ../reservation.php");
            exit();
        }
        
        // 新增訂位
        $stmt = $pdo->prepare("INSERT INTO reservations 
                              (user_id, reservation_date, reservation_time, people_count, special_request, status) 
                              VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $reservation_date, $reservation_time, $people_count, $special_request]);
        
        $_SESSION['success'] = "訂位成功！我們將盡快確認您的訂位";
        header("Location: ../reservation.php");
        exit();
        
    } catch(PDOException $e) {
        $_SESSION['error'] = "訂位失敗：" . $e->getMessage();
        header("Location: ../reservation.php");
        exit();
    }
}

header("Location: ../reservation.php");
exit(); 