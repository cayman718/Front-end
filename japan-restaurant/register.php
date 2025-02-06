<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員註冊</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    .form-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-header i {
        font-size: 48px;
        color: #0d6efd;
        margin-bottom: 15px;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn-register {
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s;
    }
    </style>
</head>

<body class="bg-light">
    <?php include 'includes/nav.php'; ?>

    <div class="container">
        <div class="form-container bg-white">
            <!-- 表單標題 -->
            <div class="form-header">
                <i class="bi bi-person-circle"></i>
                <h2>會員註冊</h2>
                <p class="text-muted">加入我們的會員計畫</p>
            </div>

            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <form method="POST" action="process/register_process.php">
                <!-- 帳號 -->
                <div class="mb-3">
                    <label class="form-label">帳號</label>
                    <input type="text" class="form-control" name="username" required minlength="3" maxlength="20"
                        placeholder="請輸入3-20個字元">
                </div>

                <!-- 電子郵件 -->
                <div class="mb-3">
                    <label class="form-label">電子郵件</label>
                    <input type="email" class="form-control" name="email" required placeholder="example@email.com">
                </div>

                <!-- 密碼 -->
                <div class="mb-3">
                    <label class="form-label">密碼</label>
                    <input type="password" class="form-control" name="password" required minlength="6"
                        placeholder="請輸入至少6個字元">
                </div>

                <!-- 確認密碼 -->
                <div class="mb-3">
                    <label class="form-label">確認密碼</label>
                    <input type="password" class="form-control" name="confirm_password" required placeholder="請再次輸入密碼">
                </div>

                <!-- 註冊按鈕 -->
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-register">
                        立即註冊
                    </button>
                </div>

                <!-- 登入連結 -->
                <p class="text-center">
                    已有帳號？<a href="login.php" class="text-decoration-none">立即登入</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
    // 輸入框效果
    $(document).ready(function() {
        $(".form-control").hover(
            function() {
                $(this).css({
                    'transform': 'scale(1.02)',
                    'box-shadow': '0 0 15px rgba(0,0,0,0.1)',
                    'transition': 'all 0.3s ease'
                });
            },
            function() {
                $(this).css({
                    'transform': 'scale(1)',
                    'box-shadow': 'none',
                    'transition': 'all 0.3s ease'
                });
            }
        );

        // 註冊按鈕效果
        $(".btn-register").hover(
            function() {
                $(this).css({
                    'transform': 'translateY(-2px)',
                    'box-shadow': '0 5px 15px rgba(13, 110, 253, 0.3)',
                    'transition': 'all 0.3s ease'
                });
            },
            function() {
                $(this).css({
                    'transform': 'translateY(0)',
                    'box-shadow': 'none',
                    'transition': 'all 0.3s ease'
                });
            }
        );
    });
    </script>
</body>

</html>