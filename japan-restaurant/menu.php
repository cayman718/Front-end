<?php
session_start();
require_once 'config/database.php';

// 獲取所有菜單分類
$categories = $pdo->query("SELECT * FROM menu_categories ORDER BY sort_order")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <title>お料理 | 匠 Fine Dining</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;500&display=swap"
        rel="stylesheet">

    <!-- 主視覺區域 -->
    <div class="menu-hero" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
         url('https://images.unsplash.com/photo-1580442151529-343f2f6e0e27?auto=format&fit=crop&w=2000')">
        <div class="container text-center">
            <h1 class="mb-4">
                <span class="jp-title">お料理</span>
                <span class="en-title">Menu</span>
            </h1>
            <div class="brush-stroke">
                <svg viewBox="0 0 100 15" class="brush-svg">
                    <path d="M0,7.5 C15,4 35,11 50,7.5 C65,4 85,11 100,7.5" class="brush-path" fill="none" stroke="#fff"
                        stroke-width="0.5" />
                </svg>
            </div>
        </div>
    </div>

    <!-- 分類導覽區域 -->
    <div class="category-section mb-5">
        <div class="container">
            <div class="category-container">
                <nav class="category-nav">
                    <div class="nav-item active" data-category="all">
                        <div class="nav-content">
                            <span class="nav-jp">全て</span>
                            <span class="nav-en">All</span>
                            <div class="nav-decoration">
                                <span class="dot"></span>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item" data-category="kaiseki">
                        <div class="nav-content">
                            <span class="nav-jp">会席料理</span>
                            <span class="nav-en">Kaiseki</span>
                            <div class="nav-decoration">
                                <span class="dot"></span>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item" data-category="seasonal">
                        <div class="nav-content">
                            <span class="nav-jp">季節の料理</span>
                            <span class="nav-en">Seasonal</span>
                            <div class="nav-decoration">
                                <span class="dot"></span>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item" data-category="sushi">
                        <div class="nav-content">
                            <span class="nav-jp">寿司</span>
                            <span class="nav-en">Sushi</span>
                            <div class="nav-decoration">
                                <span class="dot"></span>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item" data-category="sake">
                        <div class="nav-content">
                            <span class="nav-jp">お酒</span>
                            <span class="nav-en">Sake</span>
                            <div class="nav-decoration">
                                <span class="dot"></span>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- 菜品展示區域 -->
    <div class="menu-content py-4">
        <div class="container">
            <div class="menu-grid">
                <!-- 会席料理 -->
                <div class="menu-item" data-category="kaiseki">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1553621042-f6e147245754" alt="匠の懐石">
                            <div class="item-badge">
                                <span class="badge-text">匠</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">匠の懐石コース</h3>
                                    <span class="item-name-en">Premium Kaiseki Course</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>15,000
                                </div>
                            </div>
                            <div class="item-description">
                                <p>先付 ⋅ 椀物 ⋅ 造り ⋅ 焼物 ⋅ 煮物 ⋅ 食事 ⋅ 水菓子</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="menu-item" data-category="kaiseki">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1516684732162-798a0062be99" alt="季節の会席">
                            <div class="item-badge">
                                <span class="badge-text">季</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">季節の会席</h3>
                                    <span class="item-name-en">Seasonal Kaiseki</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>12,000
                                </div>
                            </div>
                            <div class="item-description">
                                <p>旬の食材を使用した会席料理</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 季節料理 -->
                <div class="menu-item" data-category="seasonal">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1579684947550-22e945225d9a" alt="旬の刺身">
                            <div class="item-badge">
                                <span class="badge-text">旬</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">旬の刺身盛り合わせ</h3>
                                    <span class="item-name-en">Seasonal Sashimi</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>4,800
                                </div>
                            </div>
                            <div class="item-description">
                                <p>本日の鮮魚五種盛り</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 寿司 -->
                <div class="menu-item" data-category="sushi">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c" alt="特上寿司">
                            <div class="item-badge">
                                <span class="badge-text">極</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">特上寿司盛り合わせ</h3>
                                    <span class="item-name-en">Premium Sushi Selection</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>6,800
                                </div>
                            </div>
                            <div class="item-description">
                                <p>厳選された旬のネタを使用した贅沢な握り</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- お酒 -->
                <div class="menu-item" data-category="sake">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://media.hoshinoresorts.com/image/authenticated/s--wfGaTaVQ--/c_fill,g_auto,h_1113,w_1520/f_auto,q_auto/v1671692570/L1010526_bswcej.jpg"
                                alt="厳選地酒">
                            <div class="item-badge">
                                <span class="badge-text">酒</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">厳選地酒</h3>
                                    <span class="item-name-en">Premium Sake Selection</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>1,200
                                </div>
                            </div>
                            <div class="item-description">
                                <p>全国各地の銘酒を取り揃え</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="menu-item" data-category="sake">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="./img/rice.jpg" alt="純米大吟醸">
                            <div class="item-badge">
                                <span class="badge-text">純</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">純米大吟醸</h3>
                                    <span class="item-name-en">Junmai Daiginjo</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>2,200
                                </div>
                            </div>
                            <div class="item-description">
                                <p>芳醇な香りと繊細な味わい</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="menu-item" data-category="sake">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTEv2_iMbYXxTgaEaDLt0gcS5OqMp6vQyAhlA&s"
                                alt="プレミアム冷酒">
                            <div class="item-badge">
                                <span class="badge-text">冷</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">プレミアム冷酒</h3>
                                    <span class="item-name-en">Premium Cold Sake</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>1,800
                                </div>
                            </div>
                            <div class="item-description">
                                <p>厳選された冷酒をご用意</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 会席料理追加 -->
                <div class="menu-item" data-category="kaiseki">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1580822184713-fc5400e7fe10" alt="四季の懐石">
                            <div class="item-badge">
                                <span class="badge-text">雅</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">四季の懐石</h3>
                                    <span class="item-name-en">Four Seasons Kaiseki</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>10,000
                                </div>
                            </div>
                            <div class="item-description">
                                <p>四季折々の食材を使用した会席料理</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 季節料理追加 -->
                <div class="menu-item" data-category="seasonal">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1534256958597-7fe685cbd745" alt="焼き物">
                            <div class="item-badge">
                                <span class="badge-text">炭</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">銀鱈の西京焼き</h3>
                                    <span class="item-name-en">Grilled Black Cod</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>3,800
                                </div>
                            </div>
                            <div class="item-description">
                                <p>味噌に漬け込んだ銀鱈を丁寧に焼き上げました</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 寿司追加 -->
                <div class="menu-item" data-category="sushi">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1563612116625-3012372fccce" alt="握り寿司">
                            <div class="item-badge">
                                <span class="badge-text">上</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">匠の握り</h3>
                                    <span class="item-name-en">Chef's Selection Nigiri</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>4,500
                                </div>
                            </div>
                            <div class="item-description">
                                <p>厳選された旬のネタ八貫</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 一品料理 -->
                <div class="menu-item" data-category="seasonal">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1526318896980-cf78c088247c" alt="天ぷら">
                            <div class="item-badge">
                                <span class="badge-text">天</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">季節の天ぷら盛り合わせ</h3>
                                    <span class="item-name-en">Seasonal Tempura</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>3,200
                                </div>
                            </div>
                            <div class="item-description">
                                <p>旬の野菜と海鮮の天ぷら</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 前菜 -->
                <div class="menu-item" data-category="seasonal">
                    <div class="item-inner">
                        <div class="item-image">
                            <img src="https://images.unsplash.com/photo-1519624014191-508652cbd7b5" alt="前菜">
                            <div class="item-badge">
                                <span class="badge-text">彩</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="item-header">
                                <div class="item-titles">
                                    <h3 class="item-name">季節の前菜五種盛り</h3>
                                    <span class="item-name-en">Seasonal Appetizer</span>
                                </div>
                                <div class="item-price">
                                    <span class="currency">¥</span>2,800
                                </div>
                            </div>
                            <div class="item-description">
                                <p>季節感溢れる前菜の盛り合わせ</p>
                            </div>
                            <button class="add-to-cart">
                                <span>注文する</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* 全域設定 */
    :root {
        --primary-dark: #2c3e50;
        --text-muted: #666666;
        --bg-light: #fafafa;
        --bg-white: #ffffff;
        --accent: #937c62;
    }

    body {
        font-family: 'Noto Serif JP', serif;
        background-color: var(--bg-light);
    }

    /* 主視覚區域 */
    .menu-hero {
        height: 60vh;
        background-position: center;
        background-size: cover;
        display: flex;
        align-items: center;
        color: #fff;
    }

    .jp-title {
        display: block;
        font-size: 3rem;
        font-weight: 200;
        letter-spacing: 0.5em;
        margin-bottom: 0.5rem;
    }

    .en-title {
        display: block;
        font-size: 1rem;
        letter-spacing: 0.3em;
        opacity: 0.8;
    }

    /* 分類導覽樣式 */
    .category-section {
        padding: 2rem 0;
        background-color: var(--bg-white);
    }

    .category-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .category-nav {
        display: flex;
        justify-content: center;
        gap: 2.5rem;
        padding: 1rem 0;
        position: relative;
    }

    .category-nav::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(to right,
                transparent,
                rgba(0, 0, 0, 0.05) 20%,
                rgba(0, 0, 0, 0.05) 80%,
                transparent);
    }

    .nav-item {
        position: relative;
        cursor: pointer;
        padding: 0.5rem 0;
    }

    .nav-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-jp {
        font-size: 1.1rem;
        font-weight: 300;
        margin-bottom: 0.3rem;
        color: var(--text-muted);
        transition: color 0.3s ease;
    }

    .nav-en {
        font-size: 0.75rem;
        color: var(--text-muted);
        opacity: 0.7;
        letter-spacing: 0.05em;
        transition: opacity 0.3s ease;
    }

    .nav-decoration {
        position: absolute;
        bottom: -1.2rem;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .dot {
        display: block;
        width: 4px;
        height: 4px;
        background-color: var(--accent);
        border-radius: 50%;
    }

    .nav-item.active .nav-jp,
    .nav-item:hover .nav-jp {
        color: var(--primary-dark);
    }

    .nav-item.active .nav-en,
    .nav-item:hover .nav-en {
        opacity: 1;
    }

    .nav-item.active .nav-decoration {
        opacity: 1;
    }

    /* 菜單網格布局 */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        padding: 1rem 0;
    }

    /* 菜品卡片樣式 */
    .menu-card {
        background: var(--bg-white);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-5px);
    }

    .card-inner {
        position: relative;
        height: 100%;
    }

    .card-image {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .menu-card:hover .card-image img {
        transform: scale(1.05);
    }

    .season-tag {
        position: absolute;
        top: 0.8rem;
        right: 0.8rem;
        width: 2.5rem;
        height: 2.5rem;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Noto Serif JP', serif;
        font-size: 1rem;
    }

    .card-content {
        padding: 1.2rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .dish-info {
        flex: 1;
        padding-right: 1rem;
    }

    .dish-name {
        font-size: 1.1rem;
        font-weight: 400;
        margin-bottom: 0.3rem;
        line-height: 1.4;
    }

    .dish-en {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    .price-order {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
    }

    .price {
        font-size: 1.1rem;
        color: var(--primary-dark);
    }

    .order-btn {
        width: 2rem;
        height: 2rem;
        border: 1px solid var(--accent);
        background: none;
        color: var(--accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .order-btn:hover {
        background: var(--accent);
        color: var(--bg-white);
    }

    /* 購物車浮動按鈕樣式 */
    .cart-float {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        z-index: 100;
    }

    .cart-preview {
        background: var(--bg-white);
        padding: 0.8rem 1.5rem;
        border-radius: 2px;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .cart-label {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .cart-toggle {
        width: 3.5rem;
        height: 3.5rem;
        border: none;
        background: var(--accent);
        color: var(--bg-white);
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .category-nav {
            gap: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .nav-item {
            padding: 0.5rem 1rem;
        }

        .nav-jp {
            font-size: 1rem;
        }

        .nav-en {
            font-size: 0.7rem;
        }
    }

    /* 菜品展示區域樣式 */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    .menu-item {
        background: var(--bg-white);
        transition: all 0.3s ease;
    }

    .item-inner {
        position: relative;
        overflow: hidden;
    }

    .item-image {
        position: relative;
        aspect-ratio: 3/2;
        overflow: hidden;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .menu-item:hover .item-image img {
        transform: scale(1.05);
    }

    .item-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge-text {
        font-family: 'Noto Serif JP', serif;
        font-size: 1rem;
        color: var(--primary-dark);
    }

    .item-info {
        padding: 1.5rem;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.8rem;
    }

    .item-titles {
        flex: 1;
        padding-right: 1rem;
    }

    .item-name {
        font-size: 1.1rem;
        font-weight: 400;
        margin-bottom: 0.3rem;
        line-height: 1.4;
    }

    .item-name-en {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .item-price {
        font-size: 1.2rem;
        color: var(--primary-dark);
        white-space: nowrap;
    }

    .currency {
        font-size: 0.9rem;
        margin-right: 0.1rem;
    }

    .item-description {
        margin-bottom: 1.2rem;
    }

    .item-description p {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin: 0;
    }

    .add-to-cart {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid var(--accent);
        background: none;
        color: var(--accent);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .add-to-cart:hover {
        background: var(--accent);
        color: var(--bg-white);
    }

    .add-to-cart i {
        font-size: 0.8rem;
    }

    /* 響應式調整 */
    @media (max-width: 768px) {
        .menu-grid {
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .item-info {
            padding: 1.2rem;
        }

        .item-name {
            font-size: 1rem;
        }
    }
    </style>
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <!-- JavaScript -->
    <!-- 先引入 jQuery (如果需要的話) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- 引入 Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- 最後引入自訂的 JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 分類篩選功能
        const categoryButtons = document.querySelectorAll('.nav-item');
        const menuItems = document.querySelectorAll('.menu-item');

        if (categoryButtons.length > 0 && menuItems.length > 0) {
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');

                    // 更新導覽列狀態
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');

                    // 篩選菜品
                    menuItems.forEach(item => {
                        if (category === 'all' || item.getAttribute('data-category') ===
                            category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        }
    });
    </script>
</body>

</html>