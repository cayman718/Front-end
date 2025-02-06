<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    $_SESSION['error'] = "請先登入";
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'cancelled' WHERE id = ? AND user_id = ?");
        $stmt->execute([$reservation_id, $user_id]);

        $_SESSION['success'] = "預約已成功取消。";
    } catch (PDOException $e) {
        $_SESSION['error'] = "取消預約失敗，請稍後再試。";
    }

    header("Location: ../reservation.php");
    exit();
}