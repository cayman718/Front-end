<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お料理 | 匠 Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Serif TC', serif;
            color: #2c3e50;
        }

        .hero-section {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1428515613728-6b4607e44363') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            text-align: center;
            color: #fff;
        }

        .hero-content {
            width: 100%;
            padding: 2rem;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 300;
            letter-spacing: 0.5em;
            margin-bottom: 2rem;
        }

        .japanese {
            font-family: 'Noto Serif JP', serif;
            font-weight: 400;
        }

        .hero-subtitle {
            font-size: 1.8rem;
            font-weight: 300;
            letter-spacing: 0.3em;
            margin-bottom: 1.5rem;
        }

        .sub-text {
            font-size: 1rem;
            letter-spacing: 0.2em;
            margin-bottom: 3rem;
            opacity: 0.9;
        }

        .btn-outline-light {
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 1rem 3rem;
            letter-spacing: 0.2em;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* 動畫效果 */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.5s;
        }

        .delay-2 {
            animation-delay: 1s;
        }

        .delay-3 {
            animation-delay: 1.5s;
        }

        /* 文字淡入效果 */
        .text-fade {
            opacity: 0.8;
            font-weight: 300;
        }

        .section-title {
            position: relative;
            margin-bottom: 4rem;
            padding-bottom: 1rem;
        }

        .section-title:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #e67e22;
        }

        .feature-card {
            padding: 3rem 2rem;
            border: none;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 2rem;
        }

        .menu-section {
            background: #f8f9fa;
            padding: 6rem 0;
        }

        .menu-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            cursor: pointer;
        }

        .menu-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .menu-item:hover img {
            transform: scale(1.1);
        }

        .menu-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: #fff;
            transition: all 0.3s ease;
        }

        .menu-item:hover .menu-overlay {
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
        }

        .badge {
            padding: 0.5em 1em;
            font-weight: 500;
        }

        .btn-outline-dark:hover {
            background: #2c3e50;
            border-color: #2c3e50;
        }

        .contact-section {
            background: #2c3e50;
            color: #fff;
            padding: 6rem 0;
        }

        .contact-info {
            padding: 2rem;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
        }

        .scroll-down {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            font-size: 2rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-30px);
            }

            60% {
                transform: translateY(-15px);
            }
        }

        /* 導覽列樣式 */
        .navbar {
            padding: 1.5rem 0;
            transition: all 0.3s ease;
        }

        /* 滾動時的背景 */
        .navbar.scrolled {
            background: rgba(0, 0, 0, 0.85) !important;
            padding: 1rem 0;
            backdrop-filter: blur(10px);
        }

        /* Logo 樣式 */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .japanese-logo {
            font-family: 'Noto Serif JP', serif;
            font-size: 2rem;
            font-weight: 500;
        }

        .brand-divider {
            color: rgba(255, 255, 255, 0.4);
            font-weight: 300;
        }

        .brand-text {
            font-size: 1.2rem;
            letter-spacing: 0.1em;
            font-weight: 300;
        }

        /* 選單項目樣式 */
        .nav-link {
            font-size: 0.95rem;
            letter-spacing: 0.2em;
            padding: 0.5rem 1.5rem !important;
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #fff !important;
        }

        /* 手機版選單按鈕 */
        .navbar-toggler {
            padding: 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* 動態背景效果 */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(0, 0, 0, 0.95);
                padding: 1rem;
                border-radius: 0.5rem;
                margin-top: 1rem;
            }
        }

        /* 通用日式風格 */
        .jp-title-small {
            display: block;
            font-family: 'Noto Serif JP', serif;
            font-size: 1.8rem;
            font-weight: 200;
            letter-spacing: 0.3em;
            margin-bottom: 0.5rem;
        }

        .en-title {
            display: block;
            font-size: 0.9rem;
            letter-spacing: 0.2em;
            color: #666;
            font-weight: 300;
        }

        /* 特色區域 */
        .feature-card {
            position: relative;
            margin-bottom: 2rem;
        }

        .feature-image {
            position: relative;
            overflow: hidden;
            aspect-ratio: 4/3;
        }

        .feature-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .feature-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .feature-content {
            position: relative;
            padding: 2rem 0;
            text-align: center;
        }

        .jp-text {
            font-family: 'Noto Serif JP', serif;
            font-weight: 300;
            letter-spacing: 0.2em;
        }

        /* 菜單預覽 */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .menu-item {
            position: relative;
        }

        .menu-tag {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            font-family: 'Noto Serif JP', serif;
            border-radius: 50%;
        }

        /* 聯絡資訊 */
        .contact-section {
            background: #f8f8f8;
            padding: 6rem 0;
        }

        .contact-wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }

        .contact-item {
            text-align: center;
        }

        .contact-icon {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .hours-grid {
            display: grid;
            gap: 0.5rem;
        }

        .note {
            color: #666;
            font-size: 0.9rem;
        }

        @media (hover: hover) {
            .feature-card:hover .feature-image img {
                transform: scale(1.05);
            }

            .feature-card:hover .feature-overlay {
                background: rgba(0, 0, 0, 0.2);
            }
        }

        /* 主廚推薦區域樣式 */
        .chef-recommend {
            background-color: #fafafa;
            padding: 5rem 0;
        }

        .jp-title-small {
            display: block;
            font-family: 'Noto Serif JP', serif;
            font-size: 2rem;
            font-weight: 200;
            letter-spacing: 0.3em;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .en-title {
            display: block;
            font-size: 1rem;
            letter-spacing: 0.2em;
            color: #666;
            font-weight: 300;
            text-transform: uppercase;
        }

        .brush-stroke {
            max-width: 200px;
            margin: 0 auto;
            padding: 1rem 0;
        }

        .brush-svg {
            width: 100%;
            height: auto;
        }

        .brush-path {
            stroke: #2c3e50;
            stroke-width: 0.5;
            opacity: 0.3;
        }

        .dish-card {
            background: #fff;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .dish-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .dish-image {
            position: relative;
            aspect-ratio: 16/9;
            overflow: hidden;
        }

        .dish-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .dish-card:hover .dish-image img {
            transform: scale(1.05);
        }

        .season-tag {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.9);
            padding: 0.5rem;
            text-align: center;
            min-width: 3.5rem;
        }

        .season-tag .kanji {
            display: block;
            font-family: 'Noto Serif JP', serif;
            font-size: 1.2rem;
            color: #2c3e50;
            line-height: 1.2;
        }

        .season-tag .season {
            display: block;
            font-size: 0.7rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .dish-info {
            padding: 2rem;
            text-align: center;
        }

        .dish-name .jp-text {
            display: block;
            font-family: 'Noto Serif JP', serif;
            font-size: 1.3rem;
            font-weight: 400;
            margin-bottom: 0.3rem;
            color: #2c3e50;
        }

        .dish-name .en-text {
            display: block;
            font-size: 0.9rem;
            color: #666;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }

        .dish-description {
            font-size: 0.9rem;
            line-height: 1.8;
            color: #666;
            margin-bottom: 1rem;
        }

        .price {
            font-family: 'Noto Serif JP', serif;
            font-size: 1.2rem;
            color: #2c3e50;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            .jp-title-small {
                font-size: 1.6rem;
            }

            .dish-info {
                padding: 1.5rem;
            }

            .dish-name .jp-text {
                font-size: 1.1rem;
            }
        }

        /* 聯絡資訊區域樣式 */
        .contact-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1514933651103-005eec06c04b') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            color: #fff;
        }

        .contact-wrapper {
            padding: 4rem 0;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }

        .contact-circle {
            width: 4rem;
            height: 4rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }

        .contact-item:hover .contact-circle {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .contact-circle i {
            font-size: 1.5rem;
            color: #fff;
        }

        .contact-text {
            font-family: 'Noto Serif JP', serif;
        }

        .contact-text p {
            font-size: 1.1rem;
            letter-spacing: 0.1em;
        }

        .contact-text small {
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .contact-grid {
                gap: 2rem;
            }

            .jp-title-small {
                font-size: 1.5rem;
            }
        }

        .footer {
            background-color: #f8f8f8;
        }

        .footer-title .jp-title-small {
            display: block;
            font-family: 'Noto Serif JP', serif;
            font-size: 1.8rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
        }

        .footer-title .en-title {
            display: block;
            font-size: 0.9rem;
            color: #666;
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        .footer-info {
            padding: 2rem;
            height: 100%;
        }

        .footer-info i {
            font-size: 1.5rem;
            color: #2c3e50;
        }

        .footer-info h5 {
            font-family: 'Noto Serif JP', serif;
            font-size: 1.1rem;
            font-weight: 400;
            color: #2c3e50;
        }

        .footer-info p {
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .footer-info small {
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .footer-title .jp-title-small {
                font-size: 1.5rem;
            }

            .footer-info {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- 導覽列 -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-transparent">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <span class="japanese-logo">匠</span>
                <span class="brand-divider">|</span>
                <span class="brand-text">Fine Dining</span>
            </a>

            <!-- 手機版選單按鈕 -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- 選單項目 -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">關於我們</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php">菜單賞析</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservation.php">預約體驗</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">會員專區</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">登出</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">登入</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 主視覺區域 -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title fade-in-up">
                <span class="japanese">匠心</span>
                <span class="text-fade">與</span>
                <span class="japanese">美味</span>
            </h1>
            <p class="hero-subtitle fade-in-up delay-1">
                一期一會的料理藝術
            </p>
            <p class="sub-text fade-in-up delay-2">
                將傳統與創新完美融合，為您呈現最精緻的餐飲體驗
            </p>
            <div class="btn-group fade-in-up delay-3">
                <a href="reservation.php" class="btn btn-outline-light btn-lg">
                    預約體驗
                </a>
            </div>
        </div>
    </section>

    <!-- 特色區域 -->
    <section id="features" class="py-6">
        <div class="container py-5">
            <h2 class="text-center section-title">
                <span class="jp-title-small">特色料理</span>
                <span class="en-title">Features</span>
            </h2>
            <div class="row g-5">
                <!-- 職人精神 -->
                <div class="col-lg-4">
                    <div class="feature-card">
                        <div class="feature-image">
                            <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da" alt="職人精神">
                            <div class="feature-overlay"></div>
                        </div>
                        <div class="feature-content">
                            <h4 class="jp-text">職人精神</h4>
                            <p class="text-muted">匠心獨具的料理藝術，傳承百年工藝</p>
                        </div>
                    </div>
                </div>

                <!-- 四季食材 -->
                <div class="col-lg-4">
                    <div class="feature-card">
                        <div class="feature-image">
                            <img src="https://images.unsplash.com/photo-1546241072-48010ad2862c" alt="四季食材">
                            <div class="feature-overlay"></div>
                        </div>
                        <div class="feature-content">
                            <h4 class="jp-text">旬の味覚</h4>
                            <p class="text-muted">嚴選當季頂級食材，完美呈現自然風味</p>
                        </div>
                    </div>
                </div>

                <!-- 空間美學 -->
                <div class="col-lg-4">
                    <div class="feature-card">
                        <div class="feature-image">
                            <img src="https://images.unsplash.com/photo-1552242718-c5360894aecd" alt="空間美學">
                            <div class="feature-overlay"></div>
                        </div>
                        <div class="feature-content">
                            <h4 class="jp-text">和の空間</h4>
                            <p class="text-muted">簡約雅致的用餐環境，享受寧靜時光</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 主廚推薦區域 -->
    <section class="chef-recommend py-6">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="mb-4">
                    <span class="jp-title-small">料理長おすすめ</span>
                    <span class="en-title">Chef's Selection</span>
                </h2>
                <div class="brush-stroke">
                    <svg viewBox="0 0 100 15" class="brush-svg">
                        <path d="M0,7.5 C15,4 35,11 50,7.5 C65,4 85,11 100,7.5" class="brush-path" fill="none"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <div class="row g-4">
                <!-- 前菜：春の桜鯛 -->
                <div class="col-lg-4 col-md-6">
                    <div class="dish-card">
                        <div class="dish-image">
                            <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c" alt="桜鯛の昆布締め"
                                class="img-fluid">
                            <div class="season-tag">
                                <span class="kanji">春</span>
                                <span class="season">Spring</span>
                            </div>
                        </div>
                        <div class="dish-info">
                            <h4 class="dish-name">
                                <span class="jp-text">桜鯛の昆布締め</span>
                                <span class="en-text">Spring Sea Bream</span>
                            </h4>
                            <p class="dish-description">
                                春の訪れを告げる桜鯛を昆布で締め、<br>
                                木の芽と共に春の香りを添えて
                            </p>
                            <div class="price">¥3,800</div>
                        </div>
                    </div>
                </div>

                <!-- 主菜：和牛炭火焼 -->
                <div class="col-lg-4 col-md-6">
                    <div class="dish-card">
                        <div class="dish-image">
                            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836" alt="和牛の炭火焼き"
                                class="img-fluid">
                            <div class="season-tag">
                                <span class="kanji">薦</span>
                                <span class="season">Special</span>
                            </div>
                        </div>
                        <div class="dish-info">
                            <h4 class="dish-name">
                                <span class="jp-text">黒毛和牛の炭火焼き</span>
                                <span class="en-text">Charcoal Grilled Wagyu</span>
                            </h4>
                            <p class="dish-description">
                                最高級A5ランクの黒毛和牛を<br>
                                備長炭で丁寧に焼き上げて
                            </p>
                            <div class="price">¥12,800</div>
                        </div>
                    </div>
                </div>

                <!-- 甜點：抹茶デザート -->
                <div class="col-lg-4 col-md-6">
                    <div class="dish-card">
                        <div class="dish-image">
                            <img src="https://images.unsplash.com/photo-1551529834-525807d6b4f3" alt="抹茶のティラミス"
                                class="img-fluid">
                            <div class="season-tag">
                                <span class="kanji">新</span>
                                <span class="season">New</span>
                            </div>
                        </div>
                        <div class="dish-info">
                            <h4 class="dish-name">
                                <span class="jp-text">抹茶のティラミス</span>
                                <span class="en-text">Matcha Tiramisu</span>
                            </h4>
                            <p class="dish-description">
                                宇治抹茶を贅沢に使用した<br>
                                和のティラミス
                            </p>
                            <div class="price">¥1,800</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 聯絡資訊區域 -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="footer-title mb-4">
                        <span class="jp-title-small">ご予約・お問い合わせ</span>
                        <span class="en-title">Contact</span>
                    </h2>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- 地址 -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-info text-center">
                        <i class="bi bi-geo-alt mb-3"></i>
                        <h5 class="mb-3">所在地</h5>
                        <p class="mb-1">台北市中山區某某路123號</p>
                        <small class="text-muted">中山駅より徒歩5分</small>
                    </div>
                </div>

                <!-- 營業時間 -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-info text-center">
                        <i class="bi bi-clock mb-3"></i>
                        <h5 class="mb-3">営業時間</h5>
                        <p class="mb-1">ランチ 11:30 - 14:30</p>
                        <p class="mb-1">ディナー 17:30 - 21:30</p>
                        <small class="text-muted">定休日：毎週火曜日</small>
                    </div>
                </div>

                <!-- 聯絡電話 -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-info text-center">
                        <i class="bi bi-telephone mb-3"></i>
                        <h5 class="mb-3">お電話</h5>
                        <p class="mb-1">02-1234-5678</p>
                        <small class="text-muted">ご予約・お問い合わせ</small>
                    </div>
                </div>
            </div>

            <!-- 版權資訊 -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="border-top pt-4">
                        <p class="text-center text-muted small mb-0">
                            © 2024 匠 Fine Dining. All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 滾動時改變導覽列背景
        document.addEventListener('DOMContentLoaded', function() {
            var navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        });
    </script>
</body>

</html>