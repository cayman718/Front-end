<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>天氣預報</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- 導航欄 -->
    <nav class="navbar navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="#">天氣預報</a>
            <div class="d-flex">
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="admin/" class="btn btn-link text-dark text-decoration-none">管理</a>
                <a href="admin/logout.php" class="btn btn-link text-dark text-decoration-none">登出</a>
                <?php else: ?>
                <a href="admin/login.php" class="btn btn-link text-dark text-decoration-none">登入</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- 搜尋框 -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <form class="d-flex border rounded" id="searchForm">
                    <input class="form-control border-0" type="search" placeholder="搜尋地區..." id="searchInput">
                    <button class="btn btn-link text-dark" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- 載入提示 -->
        <div id="loading" class="text-center mb-4" style="display:none;">
            <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">載入中...</span>
            </div>
        </div>

        <!-- 錯誤提示 -->
        <div id="error" class="alert alert-danger" style="display:none;"></div>

        <!-- 天氣資料表格 -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="fw-normal">編號</th>
                        <th class="fw-normal">地區</th>
                        <th class="fw-normal">今日白天</th>
                        <th class="fw-normal">今晚明晨</th>
                        <th class="fw-normal">明日白天</th>
                    </tr>
                </thead>
                <tbody id="weatherData">
                    <!-- API 資料會在這裡 -->
                </tbody>
                <tbody id="dbWeatherData">
                    <!-- 資料庫資料會在這裡 -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript 函式庫 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
    $(document).ready(function() {
        // 載入 API 天氣資料
        loadWeatherData();
        // 載入資料庫天氣資料
        loadDBWeatherData();

        // 搜尋功能
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            const keyword = $('#searchInput').val();
            filterWeatherData(keyword);
        });

        $('#searchInput').on('input', function() {
            const keyword = $(this).val();
            filterWeatherData(keyword);
        });
    });

    // 載入 API 天氣資料
    function loadWeatherData() {
        $('#loading').show();
        $('#error').hide();

        $.ajax({
            url: 'api/weather.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data && response.data.records && response.data.records
                    .location) {
                    updateWeatherTable(response.data.records.location, 'apiData');
                } else {
                    showError('無法取得天氣資料：' + (response.message || '未知錯誤'));
                }
            },
            error: function(xhr, status, error) {
                showError('連線錯誤：' + error);
                console.error('API Error:', xhr.responseText);
            },
            complete: function() {
                $('#loading').hide();
            }
        });
    }

    // 載入資料庫天氣資料
    function loadDBWeatherData() {
        $.ajax({
            url: 'api/db_weather.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data) {
                    updateDBWeatherTable(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error('DB Error:', xhr.responseText);
            }
        });
    }

    // 更新 API 天氣資料表格
    function updateWeatherTable(locations, tableId) {
        // 清空表格內容
        $('#weatherData').empty();

        // 設置表頭時間
        if (locations.length > 0) {
            const timeData = locations[0].weatherElement[0].time;
            for (let i = 0; i < 3; i++) {
                const startTime = new Date(timeData[i].startTime);
                const endTime = new Date(timeData[i].endTime);
                const dateStr = startTime.toLocaleDateString('zh-TW');
                const startTimeStr = startTime.toLocaleTimeString('zh-TW', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const endTimeStr = endTime.toLocaleTimeString('zh-TW', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                $(`#time${i+1}`).html(`${dateStr}<br>${startTimeStr}-${endTimeStr}`);
            }
        }

        // 填充天氣資料
        locations.forEach((location, index) => {
            let row = `<tr><td>${index + 1}</td><td>${location.locationName}</td>`;

            // 取得天氣資料
            const wx = location.weatherElement.find(el => el.elementName === 'Wx');
            const minT = location.weatherElement.find(el => el.elementName === 'MinT');
            const maxT = location.weatherElement.find(el => el.elementName === 'MaxT');

            // 填充三個時段的資料
            for (let i = 0; i < 3; i++) {
                const weather = wx.time[i].parameter.parameterName;
                const min = minT.time[i].parameter.parameterName;
                const max = maxT.time[i].parameter.parameterName;
                row += `<td>${min}°C - ${max}°C<br>${weather}</td>`;
            }

            row += '</tr>';
            $('#weatherData').append(row);
        });
    }

    // 更新資料庫天氣資料表格
    function updateDBWeatherTable(data) {
        $('#dbWeatherData').empty(); // 清空舊資料

        // 獲取 API 資料的數量作為起始編號
        const startIndex = $('#weatherData tr').length;

        data.forEach((item, index) => {
            const row = `
                    <tr>
                        <td>${startIndex + index + 1}</td>
                        <td>${item.location}</td>
                        <td>${item.temperature}<br>${item.description}</td>
                        <td>${item.temperature2 || '-'}<br>${item.description2 || '-'}</td>
                        <td>${item.temperature3 || '-'}<br>${item.description3 || '-'}</td>
                    </tr>
                `;
            $('#dbWeatherData').append(row);
        });
    }

    // 格式化日期
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleString('zh-TW', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // 修改搜尋功能
    function filterWeatherData(keyword) {
        if (!keyword) {
            $('#weatherData tr, #dbWeatherData tr').show();
            return;
        }

        // 轉換關鍵字為小寫並處理台/臺的轉換
        keyword = keyword.toLowerCase();
        const keywords = [
            keyword,
            keyword.replace('台', '臺'),
            keyword.replace('臺', '台')
        ];

        $('#weatherData tr, #dbWeatherData tr').each(function() {
            const location = $(this).find('td:eq(1)').text().toLowerCase();
            // 只要符合任一個關鍵字就顯示
            const isMatch = keywords.some(key => location.includes(key));
            $(this).toggle(isMatch);
        });
    }

    function showError(message) {
        $('#error').text(message).show();
        console.error('Error:', message);
    }
    </script>
</body>

</html>