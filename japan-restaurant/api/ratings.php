<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        // 新增評分
        if (!isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => '請先登入']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $dish_id = $data['dish_id'] ?? null;
        $rating = $data['rating'] ?? null;
        $comment = $data['comment'] ?? '';

        if (!$dish_id || !$rating) {
            http_response_code(400);
            echo json_encode(['error' => '缺少必要參數']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO ratings (dish_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$dish_id, $_SESSION['user_id'], $rating, $comment]);

        echo json_encode(['success' => $result]);
        break;
} 