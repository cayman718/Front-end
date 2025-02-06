<?php
require_once __DIR__ . '/auth.php';
?>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <span class="japanese-logo">匠</span>
            <span class="brand-divider">|</span>
            <span class="brand-text">Fine Dining</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">首頁</a>
                </li>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            會員專區
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="dashboard.php">會員總覽</a></li>
                            <li><a class="dropdown-item" href="profile.php">個人資料</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="process/logout_process.php">登出</a></li>
                        </ul>
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

<style>
    .navbar {
        padding: 1.5rem 0;
        transition: all 0.3s ease;
        background: transparent;
    }

    .navbar.scrolled {
        background: rgba(255, 255, 255, 0.95);
        padding: 1rem 0;
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

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
        color: rgba(0, 0, 0, 0.3);
        font-weight: 200;
    }

    .brand-text {
        font-size: 1.2rem;
        letter-spacing: 0.1em;
        font-weight: 300;
    }

    .nav-link {
        font-size: 0.95rem;
        letter-spacing: 0.2em;
        padding: 0.5rem 1.5rem !important;
        color: rgba(0, 0, 0, 0.7) !important;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: #000 !important;
    }

    /* 深色背景時的樣式 */
    .navbar-dark .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .navbar-dark .nav-link:hover {
        color: #fff !important;
    }

    .navbar-dark .japanese-logo,
    .navbar-dark .brand-text {
        color: #fff;
    }

    .navbar-dark .brand-divider {
        color: rgba(255, 255, 255, 0.4);
    }

    /* 下拉選單樣式 */
    .dropdown-menu {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem;
        padding: 0.5rem 0;
    }

    .dropdown-item {
        font-size: 0.9rem;
        letter-spacing: 0.1em;
        padding: 0.7rem 1.5rem;
        color: rgba(0, 0, 0, 0.7);
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background: rgba(0, 0, 0, 0.03);
        color: #000;
    }

    /* 手機版選單按鈕 */
    .navbar-toggler {
        padding: 0.5rem;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            backdrop-filter: blur(10px);
        }

        .navbar-dark .navbar-collapse {
            background: rgba(0, 0, 0, 0.9);
        }
    }
</style>

<script>
    // 滾動時改變導覽列樣式
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar');
        const isHomePage = window.location.pathname === '/' ||
            window.location.pathname === '/index.php';

        if (!isHomePage) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.add('navbar-dark');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                    navbar.classList.remove('navbar-dark');
                } else {
                    navbar.classList.remove('scrolled');
                    navbar.classList.add('navbar-dark');
                }
            });
        }
    });
</script>