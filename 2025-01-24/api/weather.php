<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');

// API URL和授權金鑰
$apiUrl = 'https://opendata.cwa.gov.tw/api/v1/rest/datastore/F-C0032-001';
$authorization = 'CWA-B067A3E9-3407-4DD6-9B5A-3B9C7D3CB1DE';

try {
    // 設置HTTP context
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => [
                'Authorization: ' . $authorization
            ],
            'timeout' => 30
        ]
    ];
    $context = stream_context_create($opts);

    // 發送請求
    $response = file_get_contents($apiUrl . '?Authorization=' . $authorization, false, $context);

    if ($response === false) {
        throw new Exception('無法取得天氣資料');
    }

    // 解析JSON
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON解析錯誤: ' . json_last_error_msg());
    }

    // 檢查API響應
    if (!isset($data['success']) || $data['success'] !== 'true') {
        throw new Exception('API 回應異常');
    }

    // 回傳成功結果
    echo json_encode([
        'success' => true,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    // 記錄錯誤
    error_log('Weather API Error: ' . $e->getMessage());

    // 回傳錯誤訊息
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}