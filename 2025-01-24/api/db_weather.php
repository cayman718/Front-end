<?php
require_once '../db_connect.php';
header('Content-Type: application/json; charset=utf-8');

try {
    // 獲取資料庫中的天氣資料
    $sql = "SELECT * FROM weather_data ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        // 格式化日期
        $row['created_at'] = date('Y-m-d H:i:s', strtotime($row['created_at']));
        $data[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
