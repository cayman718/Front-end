<?php
// 模擬資料
$locations = [
    ['id' => 1, 'name' => '巴黎', 'date' => '2023-09-24', 'description' => '浪漫之都，擁有艾菲爾鐵塔和羅浮宮。'],
    ['id' => 2, 'name' => '東京', 'date' => '2023-10-01', 'description' => '充滿活力的城市，擁有美食和文化。'],
    ['id' => 3, 'name' => '紐約', 'date' => '2023-10-15', 'description' => '不夜城，擁有自由女神像和中央公園。'],
    ['id' => 4, 'name' => '倫敦', 'date' => '2023-10-20', 'description' => '歷史悠久的城市，擁有大本鐘和倫敦塔。'],
    ['id' => 5, 'name' => '羅馬', 'date' => '2023-10-25', 'description' => '古老的城市，擁有羅馬競技場和梵蒂岡。'],
    ['id' => 6, 'name' => '巴塞隆納', 'date' => '2023-11-01', 'description' => '擁有高第建築的美麗城市。'],
    ['id' => 7, 'name' => '悉尼', 'date' => '2023-11-05', 'description' => '擁有悉尼歌劇院和美麗海灘的城市。'],
    ['id' => 8, 'name' => '香港', 'date' => '2023-11-10', 'description' => '繁華的都市，擁有維多利亞港的美景。'],
    ['id' => 9, 'name' => '新加坡', 'date' => '2023-11-15', 'description' => '現代化的城市，擁有濱海灣花園。'],
    ['id' => 10, 'name' => '首爾', 'date' => '2023-11-20', 'description' => '充滿活力的城市，擁有古老的宮殿和現代的購物區。'],
    // ['id' => 11, 'name' => '曼谷', 'date' => '2023-11-25', 'description' => '熱鬧的城市，擁有美麗的寺廟和夜市。'],
    // ['id' => 12, 'name' => '吉隆坡', 'date' => '2023-12-01', 'description' => '擁有雙子塔的現代城市。'],
    // ['id' => 13, 'name' => '雅典', 'date' => '2023-12-05', 'description' => '古老的城市，擁有帕台農神廟。'],
    // ['id' => 14, 'name' => '開羅', 'date' => '2023-12-10', 'description' => '擁有金字塔的歷史城市。'],
    // ['id' => 15, 'name' => '布宜諾斯艾利斯', 'date' => '2023-12-15', 'description' => '擁有探戈文化的城市。'],
    // ['id' => 16, 'name' => '里約熱內盧', 'date' => '2023-12-20', 'description' => '擁有美麗海灘和基督像的城市。'],
    // ['id' => 17, 'name' => '洛杉磯', 'date' => '2023-12-25', 'description' => '電影之都，擁有好萊塢。'],
    // ['id' => 18, 'name' => '芝加哥', 'date' => '2023-12-30', 'description' => '擁有壯觀天際線的城市。'],
    // ['id' => 19, 'name' => '多倫多', 'date' => '2024-01-05', 'description' => '擁有CN塔的現代城市。'],
    // ['id' => 20, 'name' => '溫哥華', 'date' => '2024-01-10', 'description' => '擁有壯麗自然景觀的城市。'],
];
?>


<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅遊地點資料</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h1 class="text-center my-4">旅遊地點資料</h1>
        <table class="table table-bordered" id="data">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名稱</th>
                    <th>日期</th>
                    <th>描述</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 遍歷模擬資料並顯示在表格中
                // foreach ($locations as $location) {
                //     echo "<tr>
                //         <td>{$location['id']}</td>
                //         <td>{$location['name']}</td>
                //         <td>{$location['date']}</td>
                //         <td>{$location['description']}</td>
                //         <td>
                //         <button class='btn btn-warning' id='edit'>Edit</button>
                //         <button class='btn btn-danger'>Delete</button>
                //         </td>
                //       </tr>";
                // }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"
        integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let data = [{
                "id": 1,
                "name": "巴黎",
                "date": "2023-09-24",
                "description": "浪漫之都，擁有艾菲爾鐵塔和羅浮宮。"
            },
            {
                "id": 2,
                "name": "東京",
                "date": "2023-10-01",
                "description": "充滿活力的城市，擁有美食和文化。"
            },
            {
                "id": 3,
                "name": "紐約",
                "date": "2023-10-15",
                "description": "不夜城，擁有自由女神像和中央公園。"
            },
            {
                "id": 4,
                "name": "倫敦",
                "date": "2023-10-20",
                "description": "歷史悠久的城市，擁有大本鐘和倫敦塔。"
            },
            {
                "id": 5,
                "name": "羅馬",
                "date": "2023-10-25",
                "description": "古老的城市，擁有羅馬競技場和梵蒂岡。"
            },
        ];
        // console.log(location);
        // 讀取 JSON 文件
        // 遍歷資料並顯示在表格中
        $.each(data, function(index, location) {
            $('#data').append(`
                    <tr>
                        <td>${location.id}</td>
                        <td>${location.name}</td>
                        <td>${location.date}</td>
                        <td>${location.description}</td>
                    </tr>
                `);
        });
    </script>

</body>

</html>