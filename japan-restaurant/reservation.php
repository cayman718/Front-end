<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    $_SESSION['error'] = "請先登入才能進行訂位";
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>御予約 - 線上訂位系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;500&family=Noto+Sans+TC:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --japanese-black: #1a1a1a;
        --japanese-gray: #484848;
        --japanese-beige: #f6f4f1;
        --japanese-accent: #8c7a6b;
        --japanese-light: #e8e6e1;
    }

    body {
        background-color: var(--japanese-beige);
        font-family: 'Noto Sans TC', sans-serif;
        padding-top: 0;
        /* 移除導覽列的 padding */
    }

    /* 新的導覽列樣式 */
    .navbar {
        background: transparent;
        transition: all 0.3s ease;
        padding: 1.5rem 0;
    }

    .navbar.scrolled {
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 1rem 0;
    }

    /* 新增頁面橫幅 */
    .reservation-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url('https://images.unsplash.com/photo-1541123437800-1bb1317badc2?q=80&w=2070&auto=format&fit=crop') no-repeat center center;
        background-size: cover;
        color: var(--japanese-beige);
        padding: 120px 0 80px;
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
    }

    .reservation-hero::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('path/to/japanese-pattern.png') repeat;
        opacity: 0.1;
    }

    /* 更新卡片樣式 */
    .card {
        background-color: #fff;
        border: none;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        border: 1px solid var(--japanese-light);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    /* 導覽列樣式 */
    .navbar-brand {
        font-family: 'Noto Serif JP', serif;
        font-size: 1.5rem;
        color: var(--japanese-black);
    }

    .nav-link {
        color: var(--japanese-gray) !important;
        padding: 0.5rem 1.5rem !important;
        font-size: 0.9rem;
        letter-spacing: 0.1em;
    }

    /* 表單元素樣式 */
    .form-label {
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--japanese-light);
        background-color: #fcfcfc;
        font-size: 0.95rem;
        letter-spacing: 0.05em;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--japanese-accent);
        box-shadow: 0 0 0 0.2rem rgba(140, 122, 107, 0.1);
    }

    .btn-primary {
        background-color: var(--japanese-accent);
        letter-spacing: 0.1em;
        font-weight: 400;
        padding: 15px 40px;
    }

    .btn-primary:hover {
        background-color: var(--japanese-black);
        transform: translateY(-2px);
    }

    /* 預約記錄樣式 */
    .history-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .history-table th,
    .history-table td {
        padding: 1rem;
        vertical-align: middle;
    }

    .history-table th {
        background-color: #f8f9fa;
        font-weight: 500;
        border-bottom: 2px solid #dee2e6;
    }

    .history-table td {
        border-bottom: 1px solid #dee2e6;
    }

    .badge {
        padding: 0.5em 1em;
        font-weight: normal;
        font-size: 0.85rem;
    }

    .btn-outline-danger {
        border-radius: 4px;
        padding: 0.375rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* 側邊資訊區塊 */
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        padding: 0.8rem 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-list li:last-child {
        border-bottom: none;
    }

    .japanese-title {
        font-weight: 300;
        letter-spacing: 0.1em;
    }

    .japanese-title::after {
        width: 30px;
        height: 1px;
        background-color: var(--japanese-accent);
    }

    .business-hours span {
        font-size: 0.95rem;
        letter-spacing: 0.05em;
    }

    .decoration-line {
        width: 1px;
        height: 50px;
        background-color: var(--japanese-accent);
        opacity: 0.3;
        margin: 2rem auto;
    }

    /* 新增營業時間樣式 */
    .business-hours span {
        font-size: 0.95rem;
        letter-spacing: 0.05em;
    }

    /* 更新表單元素樣式 */
    .form-control,
    .form-select {
        border: 1px solid var(--japanese-light);
        background-color: #fcfcfc;
        font-size: 0.95rem;
        letter-spacing: 0.05em;
    }

    /* 更新按鈕樣式 */
    .btn-primary {
        background-color: var(--japanese-accent);
        letter-spacing: 0.1em;
        font-weight: 400;
        padding: 15px 40px;
    }

    /* 更新預約記錄表格樣式 */
    .reservation-table {
        border-spacing: 0 12px;
    }

    .reservation-table tr {
        transition: all 0.3s ease;
    }

    .reservation-table tr:hover {
        background-color: var(--japanese-beige);
    }

    /* 更新狀態標籤樣式 */
    .status-badge {
        font-weight: 400;
        letter-spacing: 0.05em;
        padding: 8px 20px;
    }

    /* 為了更好的性能，可以添加媒體查詢 */
    @media (max-width: 768px) {
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('../images/hero-bg-mobile.jpg');
        }
    }
    </style>
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <!-- 新增頁面橫幅 -->
    <section class="reservation-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 mb-3" style="font-weight: 300; letter-spacing: 0.2em;">
                        ご予約
                    </h1>
                    <p class="lead mb-0" style="font-weight: 300; letter-spacing: 0.1em;">
                        線上預約 / Online Reservation
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <!-- 系統訊息 -->
        <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <div class="row">
            <div class="col-12">
                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="row justify-content-center g-4">
            <!-- 左側資訊欄 -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- 營業時間卡片 -->
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h3 class="h5 mb-4 japanese-title text-center">営業時間</h3>
                            <div class="business-hours">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>週一至週五</span>
                                    <span>11:00 - 21:00</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>週六至週日</span>
                                    <span>10:00 - 22:00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 訂位須知卡片 -->
                    <div class="card">
                        <h3 class="h5 mb-4 japanese-title text-center">訂位須知</h3>
                        <ul class="info-list">
                            <li>
                                <i class="bi bi-clock me-2"></i>
                                請提前24小時預訂
                            </li>
                            <li>
                                <i class="bi bi-people me-2"></i>
                                最多可預訂10人座位
                            </li>
                            <li>
                                <i class="bi bi-hourglass-split me-2"></i>
                                訂位保留時間為15分鐘
                            </li>
                            <li>
                                <i class="bi bi-exclamation-circle me-2"></i>
                                如需取消請提前24小時告知
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 右側預約表單 -->
            <div class="col-lg-8">
                <div class="card">
                    <h3 class="japanese-title text-center mb-4">預約資訊</h3>
                    <form method="POST" action="process/reservation_process.php">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">預約日期</label>
                                <input type="date" class="form-control" name="reservation_date" required
                                    min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">預約時間</label>
                                <select class="form-select" name="reservation_time" required>
                                    <option value="">請選擇時間</option>
                                    <?php
                                    for ($hour = 11; $hour <= 20; $hour++) {
                                        for ($min = 0; $min < 60; $min += 30) {
                                            $time = sprintf("%02d:%02d", $hour, $min);
                                            echo "<option value='$time'>$time</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">用餐人數</label>
                                <select class="form-select" name="people_count" required>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?>人</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">特殊需求</label>
                                <textarea class="form-control" name="special_request" rows="4"
                                    placeholder="若有任何特殊需求，請在此說明..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-calendar-check me-2"></i>確認預約
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 預約記錄 -->
                <div class="card">
                    <h3 class="japanese-title text-center mb-4">預約記錄</h3>
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE user_id = ? ORDER BY reservation_date DESC");
                    $stmt->execute([$_SESSION['user_id']]);
                    $reservations = $stmt->fetchAll();

                    if ($reservations): ?>
                    <div class="table-responsive">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>日期</th>
                                    <th>時間</th>
                                    <th>人數</th>
                                    <th>狀態</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservations as $reservation): ?>
                                <tr>
                                    <td><?php echo date('Y/m/d', strtotime($reservation['reservation_date'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($reservation['reservation_time'])); ?></td>
                                    <td><?php echo $reservation['people_count']; ?>人</td>
                                    <td>
                                        <?php
                                                $statusClass = match ($reservation['status']) {
                                                    'pending' => 'bg-warning',
                                                    'confirmed' => 'bg-success',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                                $statusText = match ($reservation['status']) {
                                                    'pending' => '待確認',
                                                    'confirmed' => '已確認',
                                                    'cancelled' => '已取消',
                                                    default => '未知'
                                                };
                                                ?>
                                        <span class="badge <?php echo $statusClass; ?>">
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                                // 檢查是否可以取消預約
                                                $reservation_datetime = strtotime($reservation['reservation_date'] . ' ' . $reservation['reservation_time']);
                                                $current_time = time();
                                                $can_cancel = ($reservation['status'] !== 'cancelled' &&
                                                    $reservation_datetime > $current_time &&
                                                    ($reservation_datetime - $current_time) >= 86400);

                                                if ($can_cancel):
                                                ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="confirmCancelReservation(<?php echo $reservation['id']; ?>)">
                                            <i class="bi bi-x-circle me-1"></i>取消預約
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-calendar-x display-4 mb-3 d-block"></i>
                        <p>目前沒有預約記錄</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 新增 JavaScript 處理導覽列效果 -->
    <script>
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    function confirmCancelReservation(id) {
        if (confirm('確定要取消此預約嗎？取消後將無法恢復。')) {
            window.location.href = `process/cancel_reservation.php?id=${id}`;
        }
    }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 添加 SweetAlert2 用於更好的對話框體驗 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>