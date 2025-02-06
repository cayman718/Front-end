<?php
session_start();
require_once 'includes/auth.php';
checkLogin();
require_once 'config/database.php';

// 獲取用戶資料
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    $_SESSION['error'] = "獲取資料失敗：" . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員中心 | Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        background: #f5f7fe;
    }

    .dashboard-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }

    .dashboard-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.03);
        background: linear-gradient(145deg, #ffffff, #fcfcff);
    }

    .card-title {
        font-weight: bold;
    }

    .feature-icon {
        font-size: 2rem;
        color: #4834d4;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4834d4, #686de0);
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(72, 52, 212, 0.2);
    }

    .account-info {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .account-info .card {
        border: none;
        border-radius: 15px;
        background: #f8f9fa;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .account-info h4 {
        font-weight: bold;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .info-item i {
        font-size: 1.5rem;
        color: #4834d4;
        margin-right: 15px;
    }

    .info-item span {
        font-size: 1rem;
        color: #333;
    }
    </style>
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <div class="container py-5">
        <div class="dashboard-wrapper">
            <div class="text-center mb-5">
                <h2 class="fw-bold">歡迎回來，<?php echo htmlspecialchars($user['username']); ?>！</h2>
                <p class="text-muted">探索會員中心的最新功能</p>
            </div>

            <!-- 帳戶資料區塊 -->
            <div class="account-info mb-5">
                <h4 class="mb-4">帳戶資訊</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card p-3">
                            <div class="info-item">
                                <i class="bi bi-person"></i>
                                <div>
                                    <h6 class="mb-1">會員帳號</h6>
                                    <span><?php echo htmlspecialchars($user['username']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3">
                            <div class="info-item">
                                <i class="bi bi-calendar"></i>
                                <div>
                                    <h6 class="mb-1">註冊時間</h6>
                                    <span><?php echo htmlspecialchars($user['created_at']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3">
                            <div class="info-item">
                                <i class="bi bi-envelope"></i>
                                <div>
                                    <h6 class="mb-1">電子信箱</h6>
                                    <span><?php echo htmlspecialchars($user['email']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3">
                            <div class="info-item">
                                <i class="bi bi-telephone"></i>
                                <div>
                                    <h6 class="mb-1">聯絡電話</h6>
                                    <span><?php echo htmlspecialchars($user['phone']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- 功能卡片：訂位管理 -->
                <div class="col-md-4">
                    <div class="dashboard-card p-4 text-center">
                        <i class="bi bi-calendar2-check feature-icon mb-3"></i>
                        <h5 class="card-title">訂位管理</h5>
                        <p class="text-muted">輕鬆管理您的訂位記錄</p>
                        <a href="reservation.php" class="btn btn-primary">立即查看</a>
                    </div>
                </div>

                <!-- 功能卡片：菜單瀏覽 -->
                <div class="col-md-4">
                    <div class="dashboard-card p-4 text-center">
                        <i class="bi bi-book feature-icon mb-3"></i>
                        <h5 class="card-title">菜單瀏覽</h5>
                        <p class="text-muted">探索最新的美味料理</p>
                        <a href="menu.php" class="btn btn-primary">查看菜單</a>
                    </div>
                </div>

                <!-- 功能卡片：帳戶設定 -->
                <div class="col-md-4">
                    <div class="dashboard-card p-4 text-center">
                        <i class="bi bi-person-gear feature-icon mb-3"></i>
                        <h5 class="card-title">帳戶設定</h5>
                        <p class="text-muted">個人化您的帳戶資訊</p>
                        <a href="profile.php" class="btn btn-primary">前往設定</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>