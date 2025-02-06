<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';

// 檢查是否為管理員
if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

// 新增菜單項目
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO menu_items (name, category_id, price, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $category_id, $price, $description]);
        $_SESSION['success'] = "菜單項目新增成功！";
    } catch(PDOException $e) {
        $_SESSION['error'] = "新增失敗：" . $e->getMessage();
    }
}

// 獲取所有菜單項目
$menu_items = $pdo->query("SELECT m.*, c.name as category_name 
                          FROM menu_items m 
                          LEFT JOIN menu_categories c ON m.category_id = c.id 
                          ORDER BY c.sort_order, m.name")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>菜單管理</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/nav.php'; ?>
    
    <div class="container">
        <h2>菜單管理</h2>
        
        <!-- 新增菜單項目表單 -->
        <form method="POST" class="form-section">
            <h3>新增菜單項目</h3>
            <div class="form-group">
                <label>名稱：</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>分類：</label>
                <select name="category_id" required>
                    <?php
                    $categories = $pdo->query("SELECT * FROM menu_categories ORDER BY sort_order")->fetchAll();
                    foreach($categories as $category) {
                        echo "<option value='{$category['id']}'>{$category['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>價格：</label>
                <input type="number" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label>描述：</label>
                <textarea name="description"></textarea>
            </div>
            <button type="submit" name="add_item" class="btn">新增項目</button>
        </form>

        <!-- 顯示現有菜單項目 -->
        <div class="menu-list">
            <h3>現有菜單項目</h3>
            <table>
                <thead>
                    <tr>
                        <th>名稱</th>
                        <th>分類</th>
                        <th>價格</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($menu_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <a href="edit_menu_item.php?id=<?php echo $item['id']; ?>" class="btn btn-small">編輯</a>
                            <a href="delete_menu_item.php?id=<?php echo $item['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('確定要刪除嗎？')">刪除</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 