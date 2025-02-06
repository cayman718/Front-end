<?php
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "請先登入";
        header("Location: login.php");
        exit();
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
} 