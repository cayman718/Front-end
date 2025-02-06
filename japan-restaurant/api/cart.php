<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        // 添加到購物車
        if (!isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => '請先登入']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $dish_id = $data['dish_id'] ?? null;
        $quantity = $data['quantity'] ?? 1;

        // 檢查庫存
        $stmt = $pdo->prepare("SELECT stock FROM dishes WHERE id = ?");
        $stmt->execute([$dish_id]);
        $dish = $stmt->fetch();

        if ($dish['stock'] < $quantity) {
            http_response_code(400);
            echo json_encode(['error' => '庫存不足']);
            exit;
        }

        // 添加或更新購物車
        $stmt = $pdo->prepare("
            INSERT INTO cart_items (user_id, dish_id, quantity)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE quantity = quantity + ?
        ");
        $result = $stmt->execute([$_SESSION['user_id'], $dish_id, $quantity, $quantity]);

        echo json_encode(['success' => $result]);
        break;

    case 'GET':
        // 獲取購物車內容
        if (!isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => '請先登入']);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT c.*, d.name, d.price, d.image_url
            FROM cart_items c
            JOIN dishes d ON c.dish_id = d.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($items);
        break;
} 