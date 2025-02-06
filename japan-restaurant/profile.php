<?php
session_start();
require_once 'includes/auth.php';
require_once 'config/database.php';
checkLogin();

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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人資料設定 | Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        background: #f5f7fe;
    }

    .profile-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }

    .profile-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.03);
        background: linear-gradient(145deg, #ffffff, #fcfcff);
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #4834d4;
        box-shadow: 0 0 0 4px rgba(72, 52, 212, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 0.7rem;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4834d4, #686de0);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(72, 52, 212, 0.2);
    }

    .btn-outline-secondary {
        border: 2px solid #e9ecef;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
    }

    .input-group-text {
        border: none;
        background-color: #f8f9fa;
        border-radius: 12px;
    }

    .alert {
        border: none;
        border-radius: 12px;
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 2rem;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 40px;
        height: 4px;
        background: #4834d4;
        border-radius: 2px;
    }
    </style>
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <div class="container py-5">
        <div class="profile-wrapper">
            <!-- 頁面標題 -->
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">個人資料設定</h2>
                <p class="text-muted">自訂您的個人資訊，讓我們更了解您</p>
            </div>

            <div class="profile-card p-4 p-lg-5">
                <?php if (isset($_SESSION['error']) || isset($_SESSION['success'])): ?>
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-10">
                        <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?php echo $_SESSION['error'];
                                            unset($_SESSION['error']); ?></div>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div><?php echo $_SESSION['success'];
                                            unset($_SESSION['success']); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <form method="POST" action="process/profile_process.php" class="needs-validation" novalidate>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <!-- 基本資料區塊 -->
                            <div class="mb-5">
                                <h5 class="section-title">基本資料</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-envelope-fill me-2 text-primary"></i>電子郵件
                                        </label>
                                        <input type="email" class="form-control" name="email"
                                            value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-telephone-fill me-2 text-primary"></i>聯絡電話
                                        </label>
                                        <input type="tel" class="form-control" name="phone"
                                            value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                                            pattern="[0-9]{10}">
                                        <div class="form-text">請輸入10位數字的電話號碼</div>
                                    </div>
                                </div>
                            </div>

                            <!-- 密碼設定區塊 -->
                            <div class="mb-5">
                                <h5 class="section-title">密碼設定</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-key-fill me-2 text-primary"></i>新密碼
                                        </label>
                                        <input type="password" class="form-control" name="new_password" minlength="6">
                                        <div class="form-text">如不修改請留空</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-shield-lock-fill me-2 text-primary"></i>確認新密碼
                                        </label>
                                        <input type="password" class="form-control" name="confirm_password">
                                    </div>
                                </div>
                            </div>

                            <!-- 按鈕區 -->
                            <div class="d-flex gap-3 justify-content-center mt-5">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="bi bi-check2-circle me-2"></i>儲存變更
                                </button>
                                <a href="dashboard.php" class="btn btn-outline-secondary px-5">
                                    <i class="bi bi-arrow-left me-2"></i>返回
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>