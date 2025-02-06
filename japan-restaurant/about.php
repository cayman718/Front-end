<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>關於我們 | 匠 Fine Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;500&display=swap"
        rel="stylesheet">
    <style>
    body {
        font-family: 'Noto Serif JP', serif;
        color: #1a1a1a;
        background-color: #fafafa;
    }

    .about-hero {
        height: 85vh;
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
            url('https://images.unsplash.com/photo-1514933651103-005eec06c04b') no-repeat center center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .hero-content {
        text-align: center;
        color: #fff;
        z-index: 2;
    }

    .jp-title {
        font-weight: 200;
        font-size: 3.5rem;
        letter-spacing: 0.5em;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .jp-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 1px;
        background: rgba(255, 255, 255, 0.6);
    }

    .jp-subtitle {
        font-weight: 300;
        letter-spacing: 0.3em;
        font-size: 1.2rem;
    }

    .vertical-text {
        writing-mode: vertical-rl;
        text-orientation: upright;
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.8);
        letter-spacing: 0.5em;
        font-weight: 200;
        opacity: 0.6;
        font-size: 0.9rem;
    }

    .section-wrapper {
        background: #fff;
        padding: 8rem 0;
        position: relative;
        overflow: hidden;
    }

    .section-wrapper::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(to right, transparent, #ddd, transparent);
    }

    .section-wrapper::after {
        content: "匠";
        position: absolute;
        right: 5%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12rem;
        color: rgba(0, 0, 0, 0.02);
        font-family: 'Noto Serif JP', serif;
        pointer-events: none;
    }

    .concept-card {
        padding: 4rem 3rem;
        background: linear-gradient(145deg, #ffffff, #fafafa);
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        position: relative;
    }

    .concept-card::before {
        content: '"';
        position: absolute;
        top: 2rem;
        left: 2rem;
        font-size: 4rem;
        color: rgba(0, 0, 0, 0.05);
        font-family: serif;
    }

    .concept-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
    }

    .jp-concept {
        font-size: 2rem;
        font-weight: 300;
        letter-spacing: 0.3em;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
        display: inline-block;
    }

    .jp-concept::before,
    .jp-concept::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 30px;
        height: 1px;
        background: rgba(0, 0, 0, 0.1);
    }

    .jp-concept::before {
        left: -40px;
    }

    .jp-concept::after {
        right: -40px;
    }

    .chef-image {
        width: 100%;
        height: 600px;
        object-fit: cover;
        filter: grayscale(20%);
        position: relative;
    }

    .chef-image::after {
        content: '';
        position: absolute;
        top: 20px;
        right: -20px;
        width: 100%;
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        z-index: -1;
    }

    .philosophy-section {
        background: #f5f5f5;
        padding: 8rem 0;
    }

    .philosophy-item {
        text-align: center;
        padding: 3rem 2rem;
        background: #fff;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .philosophy-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 0;
        background: #1a1a1a;
        transition: height 0.5s ease;
    }

    .philosophy-item:hover::before {
        height: 100%;
    }

    .philosophy-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
    }

    .philosophy-icon {
        font-size: 2.5rem;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .philosophy-icon::after {
        content: '';
        position: absolute;
        width: 50px;
        height: 50px;
        background: rgba(0, 0, 0, 0.03);
        border-radius: 50%;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
    }

    .jp-small {
        font-size: 1.2rem;
        letter-spacing: 0.2em;
        margin-bottom: 1rem;
        font-weight: 300;
    }

    .fade-in {
        animation: fadeInUp 1s ease forwards;
        animation-play-state: paused;
    }

    .fade-in.visible {
        animation-play-state: running;
    }

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

    /* 滾動條美化 */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .image-grid {
        position: relative;
        height: 600px;
    }

    .grid-item {
        position: absolute;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .main-image {
        width: 80%;
        height: 450px;
        top: 0;
        right: 0;
        z-index: 2;
    }

    .sub-image {
        width: 60%;
        height: 300px;
        bottom: 0;
        left: 0;
        z-index: 1;
    }

    .space-image,
    .food-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .grid-item:hover img {
        transform: scale(1.05);
    }

    .achievement-list {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .achievement-item {
        text-align: center;
        padding: 1.5rem;
        background: linear-gradient(145deg, #ffffff, #fafafa);
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .achievement-item:hover {
        transform: translateY(-5px);
    }

    .achievement-number {
        display: block;
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        background: linear-gradient(45deg, #1a1a1a, #333);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .achievement-text {
        font-size: 0.9rem;
        color: #666;
    }

    .main-image::after,
    .sub-image::after {
        content: '';
        position: absolute;
        top: 15px;
        right: -15px;
        width: 100%;
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        z-index: -1;
    }

    .sub-image::after {
        top: -15px;
        right: 15px;
    }

    @media (max-width: 991.98px) {
        .image-grid {
            height: 500px;
        }

        .main-image {
            width: 90%;
        }

        .sub-image {
            width: 70%;
        }
    }
    </style>
</head>

<body>
    <?php include './includes/nav.php'; ?>

    <!-- 主視覺區域 -->
    <section class="about-hero">
        <div class="hero-content">
            <h1 class="jp-title">匠心</h1>
            <p class="jp-subtitle">傳統與創新的完美融合</p>
        </div>
        <div class="vertical-text">
            匠心獨具 精緻美饌
        </div>
    </section>

    <!-- 理念介紹 -->
    <section class="section-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="concept-card fade-in">
                        <h2 class="jp-concept">おもてなし</h2>
                        <p class="text-center mb-5">
                            源自日本待客之道的精神，我們將這份專注與用心，
                            融入每一道料理、每一個細節之中。
                        </p>
                        <p class="text-center">
                            在這裡，不只是一頓餐點，而是一場充滿藝術與情感的饗宴。
                            讓我們帶您展開一段難忘的美食之旅。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 主廚介紹 -->
    <section class="section-wrapper">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="image-grid fade-in">
                        <div class="grid-item main-image">
                            <img src="https://images.unsplash.com/photo-1428515613728-6b4607e44363" alt="餐廳空間"
                                class="space-image">
                        </div>
                        <div class="grid-item sub-image">
                            <img src="https://images.unsplash.com/photo-1579027989536-b7b1f875659b" alt="料理藝術"
                                class="food-image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="fade-in">
                        <h3 class="jp-small">美食藝術</h3>
                        <h2 class="jp-concept mb-4">料理之道</h2>
                        <p class="mb-4">
                            在這裡，每一道料理都是一件藝術品。我們將傳統與創新融為一體，
                            以最純粹的心意，為您呈現最精緻的美食饗宴。
                        </p>
                        <div class="achievement-list mt-5">
                            <div class="achievement-item">
                                <span class="achievement-number">2020</span>
                                <span class="achievement-text">年度最佳餐廳</span>
                            </div>
                            <div class="achievement-item">
                                <span class="achievement-number">15+</span>
                                <span class="achievement-text">特色料理</span>
                            </div>
                            <div class="achievement-item">
                                <span class="achievement-number">4.9</span>
                                <span class="achievement-text">顧客評價</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 料理哲學 -->
    <section class="philosophy-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="philosophy-item fade-in">
                        <i class="bi bi-flower1 philosophy-icon"></i>
                        <h3 class="jp-small">四季の恵み</h3>
                        <p>嚴選當季食材，尊重自然之美</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="philosophy-item fade-in">
                        <i class="bi bi-heart philosophy-icon"></i>
                        <h3 class="jp-small">匠の技</h3>
                        <p>精湛廚藝，用心淬鍊每道料理</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="philosophy-item fade-in">
                        <i class="bi bi-gem philosophy-icon"></i>
                        <h3 class="jp-small">一期一会</h3>
                        <p>珍惜每次相遇，創造難忘回憶</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // 滾動動畫
    document.addEventListener('DOMContentLoaded', function() {
        const fadeElements = document.querySelectorAll('.fade-in');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        });

        fadeElements.forEach(element => {
            observer.observe(element);
        });
    });
    </script>
</body>

</html>