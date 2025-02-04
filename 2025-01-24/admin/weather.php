<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../db_connect.php';

// 處理表單提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'add') {
        $location = $_POST['location'];
        $temperature = $_POST['temperature'];
        $description = $_POST['description'];

        $sql = "INSERT INTO weather_data (location, temperature, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $location, $temperature, $description);

        if ($stmt->execute()) {
            $message = "新增成功！";
            $success = true;
        } else {
            $message = "新增失敗：" . $conn->error;
            $success = false;
        }
    } elseif ($_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $location = $_POST['location'];
        $temperature = $_POST['temperature'];
        $description = $_POST['description'];
        $temperature2 = $_POST['temperature2'];
        $description2 = $_POST['description2'];
        $temperature3 = $_POST['temperature3'];
        $description3 = $_POST['description3'];

        $sql = "UPDATE weather_data SET 
                location=?, 
                temperature=?, 
                description=?,
                temperature2=?,
                description2=?,
                temperature3=?,
                description3=?
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssssi",
            $location,
            $temperature,
            $description,
            $temperature2,
            $description2,
            $temperature3,
            $description3,
            $id
        );

        if ($stmt->execute()) {
            $message = "更新成功！";
            $success = true;
        } else {
            $message = "更新失敗：" . $conn->error;
            $success = false;
        }
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM weather_data WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "刪除成功！";
            $success = true;
        } else {
            $message = "刪除失敗：" . $conn->error;
            $success = false;
        }
    }
}

// 獲取天氣資料
$sql = "SELECT * FROM weather_data ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>天氣資料管理 - 後台管理系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- 導航欄 -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">後台管理系統</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="weather.php">天氣資料管理</a>
                <a class="nav-link" href="user.php">使用者管理</a>
                <a class="nav-link" href="logout.php">登出</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (isset($message)): ?>
        <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <!-- 新增資料表單 -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">新增天氣資料</h5>
                <form method="POST" class="row g-3">
                    <input type="hidden" name="action" value="add">
                    <div class="col-md-3">
                        <label class="form-label">地區</label>
                        <input type="text" class="form-control" name="location" placeholder="例：臺北市" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">今日白天</label>
                        <input type="text" class="form-control" name="temperature" placeholder="溫度" required>
                        <input type="text" class="form-control mt-2" name="description" placeholder="天氣描述">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">今晚明晨</label>
                        <input type="text" class="form-control" name="temperature2" placeholder="溫度">
                        <input type="text" class="form-control mt-2" name="description2" placeholder="天氣描述">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">明日白天</label>
                        <input type="text" class="form-control" name="temperature3" placeholder="溫度">
                        <input type="text" class="form-control mt-2" name="description3" placeholder="天氣描述">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">新增</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 資料列表 -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>編號</th>
                        <th>地區</th>
                        <th>今日白天</th>
                        <th>今晚明晨</th>
                        <th>明日白天</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['location'] ?? ''); ?></td>
                        <td>
                            <?php 
                            if (!empty($row['temperature'])) {
                                echo htmlspecialchars($row['temperature']);
                                if (!empty($row['description'])) {
                                    echo '<br>' . htmlspecialchars($row['description']);
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if (!empty($row['temperature2'])) {
                                echo htmlspecialchars($row['temperature2']);
                                if (!empty($row['description2'])) {
                                    echo '<br>' . htmlspecialchars($row['description2']);
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if (!empty($row['temperature3'])) {
                                echo htmlspecialchars($row['temperature3']);
                                if (!empty($row['description3'])) {
                                    echo '<br>' . htmlspecialchars($row['description3']);
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-bs-toggle="modal"
                                data-bs-target="#editModal" data-id="<?php echo $row['id']; ?>"
                                data-location="<?php echo htmlspecialchars($row['location'] ?? ''); ?>"
                                data-temperature="<?php echo htmlspecialchars($row['temperature'] ?? ''); ?>"
                                data-description="<?php echo htmlspecialchars($row['description'] ?? ''); ?>"
                                data-temperature2="<?php echo htmlspecialchars($row['temperature2'] ?? ''); ?>"
                                data-description2="<?php echo htmlspecialchars($row['description2'] ?? ''); ?>"
                                data-temperature3="<?php echo htmlspecialchars($row['temperature3'] ?? ''); ?>"
                                data-description3="<?php echo htmlspecialchars($row['description3'] ?? ''); ?>">
                                編輯
                            </button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('確定要刪除嗎？')">刪除</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 編輯用的 Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">編輯天氣資料</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">地區</label>
                                <input type="text" class="form-control" name="location" id="edit-location" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">今日白天</label>
                                <input type="text" class="form-control mb-2" name="temperature" id="edit-temperature"
                                    placeholder="例：14°C - 16°C" required>
                                <input type="text" class="form-control" name="description" id="edit-description"
                                    placeholder="例：多雲時晴">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">今晚明晨</label>
                                <input type="text" class="form-control mb-2" name="temperature2" id="edit-temperature2"
                                    placeholder="例：12°C - 14°C">
                                <input type="text" class="form-control" name="description2" id="edit-description2"
                                    placeholder="例：多雲時陰">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">明日白天</label>
                                <input type="text" class="form-control mb-2" name="temperature3" id="edit-temperature3"
                                    placeholder="例：12°C - 17°C">
                                <input type="text" class="form-control" name="description3" id="edit-description3"
                                    placeholder="例：陰時多雲">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">儲存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        // 編輯按鈕點擊事件
        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            var location = $(this).data('location');
            var temperature = $(this).data('temperature');
            var description = $(this).data('description');
            var temperature2 = $(this).data('temperature2');
            var description2 = $(this).data('description2');
            var temperature3 = $(this).data('temperature3');
            var description3 = $(this).data('description3');

            $('#edit-id').val(id);
            $('#edit-location').val(location);
            $('#edit-temperature').val(temperature);
            $('#edit-description').val(description);
            $('#edit-temperature2').val(temperature2);
            $('#edit-description2').val(description2);
            $('#edit-temperature3').val(temperature3);
            $('#edit-description3').val(description3);
        });
    });
    </script>
</body>

</html>