<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// 讀取 JSON 檔案
function loadJsonData()
{
    $jsonFile = 'data.json';
    if (!file_exists($jsonFile)) {
        return array('error' => 'JSON file not found');
    }

    $jsonContent = file_get_contents($jsonFile);
    return json_decode($jsonContent, true);
}

// 處理請求
function handleRequest()
{
    // 讀取資料
    $data = loadJsonData();
    if (isset($data['error'])) {
        return $data;
    }

    // 取得查詢參數
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // 如果有搜尋關鍵字，進行過濾
    if ($query) {
        $data = array_filter($data, function ($item) use ($query) {
            return (
                stripos($item['Name'], $query) !== false ||
                stripos($item['Description'], $query) !== false ||
                stripos($item['Zone'], $query) !== false
            );
        });
    }

    // 分頁處理
    $total = count($data);
    $offset = ($page - 1) * $limit;
    $data = array_slice(array_values($data), $offset, $limit);

    // 回傳結果
    return array(
        'status' => 'success',
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'data' => $data
    );
}

// 輸出結果
echo json_encode(handleRequest(), JSON_UNESCAPED_UNICODE);