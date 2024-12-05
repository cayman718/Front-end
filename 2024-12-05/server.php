<?php
// 設定響應頭為 JSON 格式
header('Content-Type: application/json');

// 確保接收到的資料是 POST 請求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 獲取傳來的資料
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';

    // 檢查資料是否有效
    if (!empty($name) && !empty($age)) {
        // 模擬處理資料（可以進行數據庫儲存或其他操作）
        $response = array(
            'message' => '收到您的資料！',
            'name' => $name,
            'age' => $age
        );
    } else {
        // 如果資料無效，返回錯誤訊息
        $response = array('error' => '請提供完整的資料！');
    }

    // 回傳 JSON 資料
    echo json_encode($response);
} else {
    // 如果不是 POST 請求，返回錯誤訊息
    echo json_encode(array('error' => '無效的請求'));
}
?>