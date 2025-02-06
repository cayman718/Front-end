<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // 獲取菜品列表
        $category = $_GET['category'] ?? 'all';
        $price_min = $_GET['price_min'] ?? null;
        $price_max = $_GET['price_max'] ?? null;
        $spicy_level = $_GET['spicy_level'] ?? null;

        $sql = "SELECT d.*, 
                    COALESCE(AVG(r.rating), 0) as average_rating,
                    COUNT(r.id) as rating_count
                FROM dishes d
                LEFT JOIN ratings r ON d.id = r.dish_id
                WHERE 1=1";

        if ($category !== 'all') {
            $sql .= " AND d.category = ?";
        }
        if ($price_min !== null) {
            $sql .= " AND d.price >= ?";
        }
        if ($price_max !== null) {
            $sql .= " AND d.price <= ?";
        }
        if ($spicy_level !== null) {
            $sql .= " AND d.spicy_level = ?";
        }

        $sql .= " GROUP BY d.id";
        
        // 執行查詢並返回結果
        // ...

        break;
} 