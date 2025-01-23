<?php
// 設置基本 URL 和最小參數
$baseUrl = 'https://api.finmindtrade.com/api/v4/data';

// 定義要查詢的股票代碼
$stockId = isset($_GET['data_id']) ? $_GET['data_id'] : '';   // 預設查詢 0050

// 設定日期範圍
$endDate = date('Y-m-d');
$startDate = date('Y-m-d', strtotime('-365 days')); // 最近30天的資料

// 定義要查詢的資料集
$datasets = array(
    "USStockInfo" => "美股基本資料",
    "USStockPrice" => "美股股價",
    "USStockFinancialStatements" => "財務報表",
    "USStockDividend" => "股利資料",
    "USStockInstitutionalInvestor" => "機構投資者持股",
    "USStockPE" => "本益比",
    "USStockBalanceSheet" => "資產負債表"
);

$allData = array();

// 查詢每個資料集
foreach ($datasets as $dataset => $description) {
    $params = array(
        "dataset" => $dataset,
        "data_id" => $stockId,
        "start_date" => $startDate,
        "end_date" => $endDate
    );

    $url = $baseUrl . '?' . http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['data'])) {
        $allData[$dataset] = $result['data'];
    }
}

// 輸出 HTML 表格
echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .data-section { margin-bottom: 30px; }
        h2 { color: #333; margin-top: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .search-form { margin: 20px 0; }
        input, button { padding: 8px; margin: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h1>股票資料查詢 - ' . $stockId . '</h1>
    
    <form class="search-form" method="GET">
        <input type="text" name="data_id" placeholder="輸入股票代碼" value="' . htmlspecialchars($stockId) . '">
        <button type="submit">查詢</button>
    </form>';

// 顯示每個資料集的資料
foreach ($datasets as $dataset => $description) {
    if (isset($allData[$dataset]) && !empty($allData[$dataset])) {
        echo "<div class='data-section'>
                <h2>{$description}</h2>
                <table>
                    <tr>";

        // 顯示表頭
        foreach (array_keys($allData[$dataset][0]) as $key) {
            echo "<th>" . htmlspecialchars($key) . "</th>";
        }
        echo "</tr>";

        // 顯示資料（限制顯示最新10筆）
        $count = 0;
        foreach ($allData[$dataset] as $row) {
            if ($count >= 1000) break;
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
            $count++;
        }

        echo "</table></div>";
    }
}

echo '</div></body></html>';