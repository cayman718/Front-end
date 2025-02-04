<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../db_connect.php';
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理 - 天氣預報系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">後台管理系統</a>
            <div class="navbar-nav">
                <a class="nav-link" href="weather.php">天氣資料管理</a>
                <a class="nav-link" href="user.php">使用者管理</a>
                <a class="nav-link" href="logout.php">登出</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">天氣資料統計</h5>
                        <?php
                        $sql = "SELECT COUNT(*) as count FROM weather_data";
                        $result = $conn->query($sql);
                        $count = $result->fetch_assoc()['count'];
                        ?>
                        <p class="card-text">目前共有 <?php echo $count; ?> 筆資料</p>
                        <a href="weather.php" class="btn btn-primary">管理資料</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">搜尋紀錄統計</h5>
                        <?php
                        $sql = "SELECT COUNT(*) as count FROM search_history";
                        $result = $conn->query($sql);
                        $count = $result->fetch_assoc()['count'];
                        ?>
                        <p class="card-text">共有 <?php echo $count; ?> 次搜尋</p>
                        <a href="search_history.php" class="btn btn-primary">查看紀錄</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">使用者管理</h5>
                        <?php
                        $sql = "SELECT COUNT(*) as count FROM users";
                        $result = $conn->query($sql);
                        $count = $result->fetch_assoc()['count'];
                        ?>
                        <p class="card-text">目前共有 <?php echo $count; ?> 位使用者</p>
                        <a href="user.php" class="btn btn-primary">管理使用者</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>