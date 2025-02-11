<!DOCTYPE html>
<html>

<head>
    <title>空氣品質預報</title>
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
    <table>
        <thead>
            <tr>
                <th>地區</th>
                <th>預報日期</th>
                <th>AQI指數</th>
                <th>主要污染物</th>
                <th>次要污染物</th>
                <th>發布時間</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $jsonData = file_get_contents('Air Quality.json');
            $data = json_decode($jsonData, true);

            foreach ($data as $item) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['area']) . "</td>";
                echo "<td>" . htmlspecialchars($item['forecastdate']) . "</td>";
                echo "<td>" . htmlspecialchars($item['aqi']) . "</td>";
                echo "<td>" . htmlspecialchars($item['majorpollutant'] ?? '無') . "</td>";
                echo "<td>" . htmlspecialchars($item['minorpollutant'] ?? '無') . "</td>";
                echo "<td>" . htmlspecialchars($item['publishtime']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>