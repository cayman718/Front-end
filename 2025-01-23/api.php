<?php
// 設定 CORS 標頭
header('Access-Control-Allow-Origin: *');  // 在正式環境建議設定具體的域名
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=UTF-8');

// 開啟錯誤報告
ini_set('display_errors', 1);
error_reporting(E_ALL);

$baseUrl = 'https://api.finmindtrade.com/api/v4/data';

// 接收並處理股票代碼
$stockId = isset($_GET['data_id']) ? strtoupper($_GET['data_id']) : 'AAPL';
$startDate = date('Y-m-d', strtotime('-30 days'));
$endDate = date('Y-m-d');

// 函數：發送 API 請求
function fetchData($url)
{
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30
    ));
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return array('error' => 'Curl error: ' . $error);
    }

    return json_decode($response, true);
}

// 獲取基本資料
$infoParams = array(
    "dataset" => "USStockInfo",
    "data_id" => $stockId
);
$infoUrl = $baseUrl . '?' . http_build_query($infoParams);
$infoResult = fetchData($infoUrl);

// 獲取股價資料
$priceParams = array(
    "dataset" => "USStockPrice",
    "data_id" => $stockId,
    "start_date" => $startDate,
    "end_date" => $endDate
);
$priceUrl = $baseUrl . '?' . http_build_query($priceParams);
$priceResult = fetchData($priceUrl);

// 整合資料
$response = array(
    'info' => isset($infoResult['data']) ? $infoResult['data'] : array(),
    'price' => isset($priceResult['data']) ? $priceResult['data'] : array()
);

// 如果有價格資料，進行排序和格式化
if (!empty($response['price'])) {
    // 按日期排序（從新到舊）
    usort($response['price'], function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // 格式化數字到小數點後兩位
    foreach ($response['price'] as &$item) {
        $item['Close'] = number_format($item['Close'], 2);
        $item['High'] = number_format($item['High'], 2);
        $item['Low'] = number_format($item['Low'], 2);
        $item['Adj_Close'] = number_format($item['Adj_Close'], 2);
    }
}

// 輸出 JSON 結果
echo json_encode($response);

// 記錄 API 回應（用於除錯）
error_log("Info API Response: " . json_encode($infoResult));
error_log("Price API Response: " . json_encode($priceResult));