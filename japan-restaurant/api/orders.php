<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        // 建立訂單
        if (!isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => '請先登入']);
            exit;
        }

        try {
            $pdo->beginTransaction();

            // 獲取購物車內容
            $stmt = $pdo->prepare("
                SELECT c.*, d.price, d.stock
                FROM cart_items c
                JOIN dishes d ON c.dish_id = d.id
                WHERE c.user_id = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $cart_items = $stmt->fetchAll();

            $total_amount = 0;
            foreach ($cart_items as $item) {
                // 檢查庫存
                if ($item['stock'] < $item['quantity']) {
                    throw new Exception("商品 {$item['dish_id']} 庫存不足");
                }
                $total_amount += $item['price'] * $item['quantity'];
            }

            // 建立訂單
            $stmt = $pdo->prepare("
                INSERT INTO orders (user_id, total_amount)
                VALUES (?, ?)
            ");
            $stmt->execute([$_SESSION['user_id'], $total_amount]);
            $order_id = $pdo->lastInsertId();

            // 建立訂單項目
            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, dish_id, quantity, price)
                VALUES (?, ?, ?, ?)
            ");

            foreach ($cart_items as $item) {
                $stmt->execute([
                    $order_id,
                    $item['dish_id'],
                    $item['quantity'],
                    $item['price']
                ]);

                // 更新庫存
                $pdo->prepare("
                    UPDATE dishes 
                    SET stock = stock - ? 
                    WHERE id = ?
                ")->execute([$item['quantity'], $item['dish_id']]);
            }

            // 清空購物車
            $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?")
                ->execute([$_SESSION['user_id']]);

            $pdo->commit();
            echo json_encode(['success' => true, 'order_id' => $order_id]);

        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;
} 