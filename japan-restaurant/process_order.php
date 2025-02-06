<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 檢查用戶是否登入
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('請先登入後再送出訂單');
        }

        // 接收並解析 JSON 資料
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('無效的資料格式');
        }
        
        if (empty($data['items'])) {
            throw new Exception('購物車是空的');
        }

        // 開始交易
        $pdo->beginTransaction();

        // 建立訂單主檔
        $orderNumber = 'ORD' . date('YmdHis');
        $totalAmount = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $data['items']));

        $stmt = $pdo->prepare("INSERT INTO orders (order_number, user_id, total_amount) VALUES (?, ?, ?)");
        if (!$stmt->execute([$orderNumber, $_SESSION['user_id'], $totalAmount])) {
            throw new Exception('建立訂單失敗');
        }
        
        $orderId = $pdo->lastInsertId();

        // 建立訂單明細
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, menu_item_id, item_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($data['items'] as $item) {
            if (!$stmt->execute([
                $orderId,
                $item['id'],
                $item['name'],
                $item['quantity'],
                $item['price']
            ])) {
                throw new Exception('建立訂單明細失敗');
            }
        }

        // 提交交易
        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => '訂單已成功送出',
            'orderNumber' => $orderNumber
        ]);

    } catch (Exception $e) {
        // 發生錯誤時回滾交易
        if ($pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        
        // 記錄錯誤
        error_log('Order Error: ' . $e->getMessage());
        
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => '無效的請求方法'
    ]);
} 