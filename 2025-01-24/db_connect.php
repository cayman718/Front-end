<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'weather';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    // 建立 PDO 連接
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    // 相容性支援：建立 mysqli 連接
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("連接失敗: " . $conn->connect_error);
    }
    $conn->set_charset($charset);
} catch (Exception $e) {
    // 記錄錯誤但不顯示詳細資訊給使用者
    error_log("資料庫連接錯誤: " . $e->getMessage());
    die("無法連接到資料庫，請聯繫管理員");
}

// 防止直接訪問此檔案
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header('HTTP/1.0 403 Forbidden');
    exit('Access Forbidden');
}