<?php
require_once 'config.php';

// 處理爬蟲請求
if (isset($_POST['scrape'])) {
    require_once 'stock_crawler.php';
    try {
        $pages_to_scrape = isset($_POST['pages']) ? (int)$_POST['pages'] : 1;
        $stocks = getYahooFinanceData($pages_to_scrape);
        if (!empty($stocks)) {
            $inserted = saveToDatabase($stocks);
            $success_message = "Successfully scraped {$inserted} stocks from {$pages_to_scrape} pages!";
        }
    } catch (Exception $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

try {
    $pdo = getDBConnection();

    // 設定每頁顯示的記錄數
    $records_per_page = 10;

    // 獲取當前頁碼
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $records_per_page;

    // 獲取總記錄數
    $stmt = $pdo->query("SELECT COUNT(*) FROM stocks");
    $total_records = $stmt->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);

    // 獲取當前頁的記錄
    $stmt = $pdo->prepare("SELECT * FROM stocks ORDER BY created_at DESC LIMIT :offset, :records_per_page");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':records_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Stock Market Data</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a,
    .pagination span {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 4px;
    }

    .pagination a:hover {
        background-color: #ddd;
    }

    .pagination .active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }

    .pagination .disabled {
        color: #aaa;
        pointer-events: none;
    }

    .positive {
        color: green;
    }

    .negative {
        color: red;
    }

    .button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #45a049;
    }

    .message {
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    </style>
</head>

<body>
    <h1>Most Active Stocks</h1>

    <!-- 抓取按鈕 -->
    <form method="POST">
        <label for="pages">Number of pages to scrape (1-10):</label>
        <input type="number" id="pages" name="pages" value="1" min="1" max="10" style="width: 60px; margin: 0 10px;">
        <button type="submit" name="scrape" class="button">Scrape Latest Data</button>
    </form>

    <!-- 顯示訊息 -->
    <?php if (isset($success_message)): ?>
    <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
    <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- 資料統計 -->
    <div class="stats">
        <p>Total Records: <?php echo $total_records; ?></p>
        <p>Page <?php echo $current_page; ?> of <?php echo $total_pages; ?></p>
        <?php if (!empty($stocks)): ?>
        <p>Last Update: <?php echo date('Y-m-d H:i:s', strtotime($stocks[0]['created_at'])); ?></p>
        <?php endif; ?>
    </div>

    <!-- 股票資料表格 -->
    <table>
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Price</th>
                <th>Change</th>
                <th>Change %</th>
                <th>Volume</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($stocks)): ?>
            <tr>
                <td colspan="7" style="text-align: center;">No data available. Please click "Scrape Latest Data" to
                    fetch stock data.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($stocks as $stock): ?>
            <tr>
                <td><?php echo htmlspecialchars($stock['symbol']); ?></td>
                <td><?php echo htmlspecialchars($stock['name']); ?></td>
                <td>$<?php echo number_format($stock['price'], 2); ?></td>
                <td class="<?php echo $stock['change_amount'] >= 0 ? 'positive' : 'negative'; ?>">
                    <?php echo ($stock['change_amount'] >= 0 ? '+' : '') . number_format($stock['change_amount'], 2); ?>
                </td>
                <td class="<?php echo $stock['change_percent'] >= 0 ? 'positive' : 'negative'; ?>">
                    <?php echo ($stock['change_percent'] >= 0 ? '+' : '') . number_format($stock['change_percent'], 2); ?>%
                </td>
                <td><?php echo number_format($stock['volume']); ?></td>
                <td><?php echo date('Y-m-d H:i:s', strtotime($stock['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- 分頁導航 -->
    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php if ($current_page > 1): ?>
        <a href="?page=1">&laquo; First</a>
        <a href="?page=<?php echo $current_page - 1; ?>">&lsaquo; Prev</a>
        <?php else: ?>
        <span class="disabled">&laquo; First</span>
        <span class="disabled">&lsaquo; Prev</span>
        <?php endif; ?>

        <?php
            $start_page = max(1, $current_page - 2);
            $end_page = min($total_pages, $current_page + 2);

            for ($i = $start_page; $i <= $end_page; $i++): ?>
        <?php if ($i == $current_page): ?>
        <span class="active"><?php echo $i; ?></span>
        <?php else: ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
        <a href="?page=<?php echo $current_page + 1; ?>">Next &rsaquo;</a>
        <a href="?page=<?php echo $total_pages; ?>">Last &raquo;</a>
        <?php else: ?>
        <span class="disabled">Next &rsaquo;</span>
        <span class="disabled">Last &raquo;</span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</body>

</html>