<?php
require_once 'config.php';

function getYahooFinanceData($pages = 1)
{
    $allStocks = [];
    $seenSymbols = []; // 用來追蹤已經抓取的股票代號

    for ($page = 0; $page < $pages; $page++) {
        // Yahoo Finance 使用 start 參數來分頁，每頁 25 筆資料
        $start = $page * 25;
        $url = "https://finance.yahoo.com/markets/stocks/most-active/?start={$start}&count=25";

        $options = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language: en-US,en;q=0.5',
                    'Connection: keep-alive',
                ]
            ]
        ];

        $context = stream_context_create($options);

        // 添加延遲以避免被封鎖
        if ($page > 0) {
            sleep(2);
        }

        try {
            echo "Fetching page " . ($page + 1) . " (start={$start})...\n";
            $html = file_get_contents($url, false, $context);

            if (empty($html)) {
                throw new Exception("Empty response from Yahoo Finance");
            }

            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // 找到表格內容
            $rows = $xpath->query("//table//tbody/tr");

            if ($rows->length === 0) {
                echo "No rows found on page " . ($page + 1) . "\n";
                continue;
            }

            foreach ($rows as $row) {
                $symbol = trim($xpath->query(".//td[1]//a", $row)->item(0)?->textContent ?? '');

                // 檢查是否已經抓取過這個股票
                if (empty($symbol) || in_array($symbol, $seenSymbols)) {
                    continue;
                }

                $name = trim($xpath->query(".//td[2]", $row)->item(0)?->textContent ?? '');
                $price = trim($xpath->query(".//td[3]//fin-streamer", $row)->item(0)?->textContent ?? '');
                $change = trim($xpath->query(".//td[4]//fin-streamer", $row)->item(0)?->textContent ?? '');
                $changePercent = trim($xpath->query(".//td[5]//fin-streamer", $row)->item(0)?->textContent ?? '');
                $volume = trim($xpath->query(".//td[6]//fin-streamer", $row)->item(0)?->textContent ?? '');

                if ($symbol && $name) {
                    $allStocks[] = [
                        'symbol' => $symbol,
                        'name' => $name,
                        'price' => $price,
                        'change' => $change,
                        'change_percent' => $changePercent,
                        'volume' => $volume
                    ];
                    $seenSymbols[] = $symbol; // 記錄已處理的股票代號
                    echo "Added new stock: {$symbol}\n";
                }
            }

            echo "Completed page " . ($page + 1) . ", unique stocks found: " . count($seenSymbols) . "\n";
        } catch (Exception $e) {
            echo "Error on page " . ($page + 1) . ": " . $e->getMessage() . "\n";
            continue;
        }
    }

    echo "Total unique stocks found: " . count($seenSymbols) . "\n";
    return $allStocks;
}

function saveToDatabase($stocks)
{
    try {
        $pdo = getDBConnection();

        // 清空舊資料
        $pdo->exec("TRUNCATE TABLE stocks");

        // 插入新資料
        $stmt = $pdo->prepare("INSERT INTO stocks 
                              (symbol, name, price, change_amount, change_percent, volume, created_at) 
                              VALUES 
                              (:symbol, :name, :price, :change, :change_percent, :volume, NOW())");

        $inserted = 0;
        foreach ($stocks as $stock) {
            $stmt->execute([
                ':symbol' => $stock['symbol'],
                ':name' => $stock['name'],
                ':price' => str_replace(['$', ','], '', $stock['price']),
                ':change' => str_replace(['$', ','], '', $stock['change']),
                ':change_percent' => str_replace(['%', '(', ')', ','], '', $stock['change_percent']),
                ':volume' => str_replace(['M', 'B', ','], '', $stock['volume'])
            ]);
            $inserted++;
        }

        return $inserted;
    } catch (PDOException $e) {
        throw new Exception("Database Error: " . $e->getMessage());
    }
}

// 創建資料表的SQL
function createTable()
{
    return "
    CREATE TABLE IF NOT EXISTS stocks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        symbol VARCHAR(10) NOT NULL,
        name VARCHAR(255) NOT NULL,
        price DECIMAL(10,2),
        change_amount DECIMAL(10,2),
        change_percent DECIMAL(10,2),
        volume BIGINT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
}

// 顯示結果的HTML
function displayStocks($stocks)
{
?>
<!DOCTYPE html>
<html>

<head>
    <title>Stock Market Data</title>
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    </style>
</head>

<body>
    <h1>Most Active Stocks</h1>
    <table>
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Price</th>
                <th>Change</th>
                <th>Change %</th>
                <th>Volume</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stocks as $stock): ?>
            <tr>
                <td><?= htmlspecialchars($stock['symbol']) ?></td>
                <td><?= htmlspecialchars($stock['name']) ?></td>
                <td><?= htmlspecialchars($stock['price']) ?></td>
                <td><?= htmlspecialchars($stock['change']) ?></td>
                <td><?= htmlspecialchars($stock['change_percent']) ?></td>
                <td><?= htmlspecialchars($stock['volume']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
<?php
}

// 主程序
try {
    $stocks = getYahooFinanceData();

    if (!empty($stocks)) {
        $result = saveToDatabase($stocks);
        echo "Data saved successfully! Inserted: " . $result . "\n";
    } else {
        echo "No stocks data was retrieved.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>