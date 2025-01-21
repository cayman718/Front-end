class BasketballGame {
    constructor() {
        this.ball = document.getElementById('ball');
        this.net = document.getElementById('net');
        this.scoreElement = document.getElementById('score');
        this.powerMeter = document.getElementById('powerMeter');
        this.powerBar = document.getElementById('powerBar');
        this.tutorial = document.getElementById('tutorial');

        this.score = 0;
        this.ballX = 400;
        this.ballY = 500;
        this.velocityX = 0;
        this.velocityY = 0;
        this.gravity = 0.4;
        this.friction = 0.995;
        this.isAnimating = false;
        this.scored = false;

        // 音效
        this.bounceSound = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-basketball-ball-hard-hit-2093.mp3');
        this.scoreSound = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-achievement-bell-600.mp3');
        this.crowdCheerSound = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-crowd-happy-cheer-437.mp3');

        // 新增籃球物理參數
        this.bounceForce = 0.65; // 反彈力
        this.spinEffect = 0.1; // 旋轉效果

        // 獲取遊戲容器和籃框位置
        this.gameContainer = document.getElementById('gameContainer');
        const netElement = document.getElementById('net');
        const netRect = netElement.getBoundingClientRect();
        const containerRect = this.gameContainer.getBoundingClientRect();

        // 計算籃框中心位置
        this.netCenterX = 400; // 固定在容器中心
        this.netY = 200; // 籃框高度

        // 設置球的初始位置和移動限制
        this.initialBallX = this.netCenterX - 30; // 初始位置在籃框下方
        this.initialBallY = 500;
        this.ballX = this.initialBallX;
        this.ballY = this.initialBallY;
        this.minBallX = 20; // 最左邊界
        this.maxBallX = 800; // 最右邊界
        this.ballMoveSpeed = 15; // 球的移動速度

        // 投籃參數調整
        this.angle = 40; // 初始角度
        this.minAngle = 20; // 最小角度
        this.maxAngle = 100; // 最大角度
        this.angleStep = 2; // 角度調整步長

        // 力道參數
        this.power = 0;
        this.maxPower = 80;
        this.powerIncreaseSpeed = 1.3;
        this.optimalPowerRange = {
            min: 45,
            max: 65
        };

        // 物理參數微調
        this.gravity = 0.45;
        this.friction = 0.997;
        this.baseVelocity = 17;

        // 新增狀態顯示
        this.statsDisplay = document.createElement('div');
        this.statsDisplay.className = 'stats-display';
        this.gameContainer.appendChild(this.statsDisplay);

        // 確保綁定 resetGame 方法
        this.resetGame = this.resetGame.bind(this);
        this.setupGame();

        // 設置音量
        this.bounceSound.volume = 0.3;
        this.scoreSound.volume = 0.5;
        this.crowdCheerSound.volume = 0.4;

        // 遊戲狀態
        this.gameStarted = false;
        this.gameTime = 60;
        this.currentTime = this.gameTime;
        this.isLastTenSeconds = false;
        this.timer = null;

        // 修改為用 class 選擇器
        this.timerDisplay = document.querySelector('.timer-display');
        if (this.timerDisplay) {
            this.timerDisplay.textContent = this.gameTime;
        }

        // 得分區域設定
        this.twoPointLine = 400; // 二分線距離
        this.threePointLine = 500; // 三分線距離

        // 遊戲音效
        this.startSound = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-arcade-game-complete-or-approved-mission-205.mp3');
        this.timeWarningSound = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-alarm-digital-clock-beep-989.mp3');
        this.gameOverSound = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-game-over-trombone-1940.mp3');

        // 設置音量
        this.startSound.volume = 0.3;
        this.timeWarningSound.volume = 0.3;
        this.gameOverSound.volume = 0.4;

        // 得分設定
        this.basePoints = 1; // 基礎得分

        // 移除舊的最後10秒提示元素（如果存在）
        const oldLastTenSeconds = document.querySelector('.last-ten-seconds-message');
        if (oldLastTenSeconds) {
            oldLastTenSeconds.remove();
        }

        // 在 constructor 中添加最高分初始化
        this.highScore = parseInt(localStorage.getItem('basketballHighScore')) || 0;
    }

    setupGame() {
        this.initializeBall();
        this.setupEventListeners();
        this.showTutorial();
        this.updateStatsDisplay();
    }

    updateStatsDisplay() {
        const angleValue = document.querySelector('.angle-value');
        const powerValue = document.querySelector('.power-value');

        if (angleValue) {
            angleValue.textContent = `${this.angle}°`;
        }

        if (powerValue) {
            powerValue.textContent = `${Math.floor((this.power / this.maxPower) * 100)}%`;
        }
    }

    setupEventListeners() {
        document.addEventListener('keydown', (e) => {
            if (!this.isAnimating) {
                switch (e.code) {
                    case 'ArrowLeft':
                        // 左移球
                        this.ballX = Math.max(this.minBallX, this.ballX - this.ballMoveSpeed);
                        this.ball.style.left = this.ballX + 'px';
                        break;
                    case 'ArrowRight':
                        // 右移球
                        this.ballX = Math.min(this.maxBallX, this.ballX + this.ballMoveSpeed);
                        this.ball.style.left = this.ballX + 'px';
                        break;
                    case 'ArrowUp':
                        // 增加角度
                        this.angle = Math.min(this.angle + this.angleStep, this.maxAngle);
                        break;
                    case 'ArrowDown':
                        // 減少角度
                        this.angle = Math.max(this.angle - this.angleStep, this.minAngle);
                        break;
                    case 'Space':
                        if (!e.repeat) {
                            e.preventDefault();
                            this.startCharging();
                        }
                        break;
                }
                this.updateStatsDisplay();
            }
        });

        document.addEventListener('keyup', (e) => {
            if (e.code === 'Space' && !this.isAnimating) {
                e.preventDefault();
                this.shoot();
            }
        });

        // 添加開始按鈕監聽
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Enter' && !this.gameStarted) {
                this.startGame();
            }
        });
    }

    startCharging() {
        if (this.isAnimating) return;
        this.isPowerCharging = true;
        this.power = 0;
        this.powerMeter.style.display = 'block';
        this.chargePower();
    }

    chargePower() {
        if (!this.isPowerCharging) return;

        this.power = Math.min(this.power + this.powerIncreaseSpeed, this.maxPower);
        const percentage = (this.power / this.maxPower) * 100;

        // 更新力道條顏色
        if (percentage >= this.optimalPowerRange.min &&
            percentage <= this.optimalPowerRange.max) {
            this.powerBar.style.backgroundColor = '#4CAF50';
        } else {
            this.powerBar.style.backgroundColor = '#ff4d4d';
        }

        this.powerBar.style.width = percentage + '%';
        this.updateStatsDisplay();

        requestAnimationFrame(() => this.chargePower());
    }

    shoot() {
        if (!this.gameStarted) {
            this.showMessage('請按 Enter 開始遊戲！');
            return;
        }
        if (this.isAnimating) return;

        this.isPowerCharging = false;
        this.powerMeter.style.display = 'none';

        // 計算到籃框的向量
        const dx = this.netCenterX - (this.ballX + 15);
        const dy = this.netY - this.ballY;
        const distance = Math.sqrt(dx * dx + dy * dy);

        // 計算投籃角度（使用固定的拋物線角度）
        const throwAngle = 85 * Math.PI / 180; // 固定85度的投籃角度

        // 計算所需的初速度
        const powerMultiplier = this.calculatePowerMultiplier();

        // 根據距離調整基礎速度
        const distanceFactor = Math.min(distance / 300, 1.5);
        const velocity = (this.baseVelocity + (this.power / 100) * 10) * distanceFactor;

        // 計算水平和垂直分量
        const horizontalDirection = dx > 0 ? 1 : -1; // 確定水平方向

        // 設置速度分量
        this.velocityX = horizontalDirection * velocity * Math.cos(throwAngle) * powerMultiplier;
        this.velocityY = -velocity * Math.sin(throwAngle) * powerMultiplier;

        // 根據距離調整水平速度
        const horizontalAdjustment = Math.abs(dx) / 200;
        this.velocityX *= horizontalAdjustment;

        this.animateBall();
    }

    calculatePowerMultiplier() {
        const normalizedPower = this.power / this.maxPower;

        if (this.power >= this.optimalPowerRange.min &&
            this.power <= this.optimalPowerRange.max) {
            return 1.1; // 適度的力道獎勵
        }

        return 0.8 + (0.3 * normalizedPower); // 基礎倍率
    }

    showTutorial() {
        this.tutorial.style.display = 'block';
        document.addEventListener('click', () => {
            this.tutorial.style.display = 'none';
        }, { once: true });
    }

    initializeBall() {
        this.ball.style.left = this.ballX + 'px';
        this.ball.style.top = this.ballY + 'px';
        this.ball.style.display = 'block'; // 確保球是可見的
    }

    checkScore() {
        const netRect = this.net.getBoundingClientRect();
        const ballRect = this.ball.getBoundingClientRect();
        const containerRect = this.gameContainer.getBoundingClientRect();

        // 調整判定區域
        const scoreZone = {
            left: netRect.left - containerRect.left + 2,
            right: netRect.right - containerRect.left - 2,
            top: netRect.top - containerRect.top - 10,
            bottom: netRect.top - containerRect.top + 10
        };

        // 判定球是否進框
        if (this.ballX + 6 > scoreZone.left &&
            this.ballX + 6 < scoreZone.right &&
            this.ballY + 6 > scoreZone.top &&
            this.ballY + 6 < scoreZone.bottom &&
            !this.scored &&
            this.velocityY > 0) {

            return true;
        }
        return false;
    }

    resetGame() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }

        this.gameStarted = false;
        this.currentTime = this.gameTime;
        this.isLastTenSeconds = false;
        this.score = 0;
        this.scoreElement.textContent = '0';

        // 重置計時器顯示
        if (this.timerDisplay) {
            this.timerDisplay.style.color = '#ff0000';
            this.timerDisplay.textContent = this.gameTime;
        }

        // 重置球的位置
        this.resetBallPosition();

        // 移除所有訊息
        const messages = document.querySelectorAll('.game-message');
        messages.forEach(msg => msg.remove());
    }

    animateBall() {
        this.isAnimating = true;
        this.scored = false;
        let spin = 0;

        const animate = () => {
            if (!this.isAnimating) return;

            // 更新速度
            this.velocityX *= this.friction;
            this.velocityY *= this.friction;
            this.velocityY += this.gravity;

            // 更新位置
            this.ballX += this.velocityX;
            this.ballY += this.velocityY;

            // 檢查邊界
            if (this.ballY > 550 ||
                this.ballX < -150 ||
                this.ballX > 850 ||
                (this.ballY < this.netY && Math.abs(this.ballX - this.netCenterX) > 250)) {
                this.resetBallPosition();
                return;
            }

            // 更新球的位置和旋轉
            spin += this.velocityX * 0.5;
            this.ball.style.left = this.ballX + 'px';
            this.ball.style.top = this.ballY + 'px';
            this.ball.style.transform = `rotate(${spin}deg)`;

            // 檢查得分
            if (this.checkScore()) {
                this.handleScore();
            }

            requestAnimationFrame(animate);
        };

        animate();
    }

    handleScore() {
        // 直接檢查是否在最後10秒
        let scoreValue = this.isLastTenSeconds ? 3 : this.calculateScoreValue();

        // 更新分數
        this.score += scoreValue;
        this.scoreElement.textContent = this.score;

        // 播放音效
        this.scoreSound.play();
        setTimeout(() => this.crowdCheerSound.play(), 300);

        // 籃網動畫
        this.net.classList.add('net-shake');
        setTimeout(() => this.net.classList.remove('net-shake'), 500);

        // 顯示得分特效
        this.showScoreEffect(scoreValue);

        // 顯示得分訊息
        if (this.isLastTenSeconds) {
            this.showScoreMessage('最後衝刺！ +3分！');
        } else {
            this.showScoreMessage(
                scoreValue === 3 ? '4分球！' : '',
                scoreValue === 2 ? '2分球！' : '',
                '得分！'
            );
        }

        this.scored = true;
    }

    calculateScoreValue() {
        // 最後10秒強制返回3分
        if (this.isLastTenSeconds) {
            return 3;
        }

        // 計算與籃框的距離
        const dx = this.ballX - this.netCenterX;
        const dy = this.ballY - this.netY;
        const distance = Math.sqrt(dx * dx + dy * dy);

        // 正常時間的得分計算
        if (distance >= this.threePointLine) {
            return 3;
        } else if (distance >= this.twoPointLine) {
            return 2;
        }
        return 1;
    }

    showScoreEffect(points) {
        const effect = document.createElement('div');
        effect.className = 'score-effect';

        // 在最後10秒添加特殊效果
        if (this.isLastTenSeconds) {
            effect.classList.add('last-ten-seconds-score');
        }

        effect.textContent = `+${points}`;
        effect.style.left = this.ballX + 'px';
        effect.style.top = this.ballY + 'px';
        this.gameContainer.appendChild(effect);

        // 添加彩色粒子效果
        this.createScoreParticles(this.isLastTenSeconds);

        setTimeout(() => effect.remove(), 1000);
    }

    showScoreMessage(message) {
        // 移除舊的得分訊息（如果存在）
        const oldScoreMessage = document.querySelector('.score-message');
        if (oldScoreMessage) {
            oldScoreMessage.remove();
        }

        const messageElement = document.createElement('div');
        messageElement.className = 'score-message';

        if (this.isLastTenSeconds) {
            messageElement.classList.add('last-ten-seconds-message');
        }

        messageElement.textContent = message;
        this.gameContainer.appendChild(messageElement);

        setTimeout(() => {
            if (messageElement && messageElement.parentNode) {
                messageElement.remove();
            }
        }, 1500);
    }

    createScoreParticles(isLastTenSeconds) {
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'score-particle';
            particle.style.left = (this.ballX + 25) + 'px';
            particle.style.top = (this.ballY + 25) + 'px';

            // 隨機顏色
            const colors = ['#FFD700', '#FF6B6B', '#4CAF50', '#87CEEB'];
            particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];

            // 隨機運動方向
            const angle = (Math.random() * Math.PI * 2);
            const velocity = 2 + Math.random() * 3;
            particle.style.setProperty('--angle', angle + 'rad');
            particle.style.setProperty('--velocity', velocity + 'px');

            this.gameContainer.appendChild(particle);
            setTimeout(() => particle.remove(), 1000);
        }
    }

    handleCollisions() {
        // 檢查邊界碰撞
        if (this.ballX <= 0 || this.ballX >= 750) {
            this.velocityX *= -0.8;
            this.bounceSound.play();
        }
        if (this.ballY <= 0 || this.ballY >= 550) {
            this.velocityY *= -0.8;
            this.bounceSound.play();
        }
    }

    shouldReset() {
        // 當球停止運動時重置
        if (Math.abs(this.velocityX) < 0.1 && Math.abs(this.velocityY) < 0.1 && this.ballY > 500) {
            return true;
        }
        return false;
    }

    resetBallPosition() {
        this.isAnimating = false;
        // 保持當前X位置，只重置Y位置
        this.ballY = this.initialBallY;
        this.velocityX = 0;
        this.velocityY = 0;
        this.ball.style.left = this.ballX + 'px';
        this.ball.style.top = this.ballY + 'px';
        this.ball.style.transform = 'rotate(0deg)';
    }

    startGame() {
        if (this.gameStarted) return;

        // 重置遊戲狀態
        this.gameStarted = true;
        this.score = 0;
        this.currentTime = this.gameTime;
        this.isLastTenSeconds = false;
        this.scoreElement.textContent = '0';

        // 播放開始音效
        this.startSound.play();

        // 隱藏教學
        this.tutorial.style.display = 'none';

        // 確保先清除舊的計時器
        if (this.timer) {
            clearInterval(this.timer);
        }

        // 設置新的計時器
        this.timer = setInterval(() => {
            if (this.currentTime > 0) {
                this.currentTime--;
                this.updateTimerDisplay();
            } else {
                this.endGame();
            }
        }, 1000);

        // 立即更新顯示
        this.updateTimerDisplay();
    }

    updateTimerDisplay() {
        if (!this.gameStarted || !this.timerDisplay) return;

        console.log('Updating timer:', this.currentTime); // 添加除錯訊息

        // 更新時間顯示
        this.timerDisplay.textContent = Math.max(0, this.currentTime);

        // 最後10秒的特殊處理
        if (this.currentTime <= 10) {
            if (!this.isLastTenSeconds) {
                this.timeWarningSound.play();
                this.isLastTenSeconds = true;
                this.showMessage('最後10秒！所有進球都是3分！');
            }
            this.timerDisplay.style.color = '#ff4d4d';
        }
    }

    endGame() {
        // 確保清除計時器
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }

        // 更新最高分
        if (this.score > this.highScore) {
            this.highScore = this.score;
            localStorage.setItem('basketballHighScore', this.score);
        }

        this.gameStarted = false;
        this.gameOverSound.play();
        this.showGameOverScreen();
    }

    showGameOverScreen() {
        // 移除舊的結束畫面（如果存在）
        const oldGameOver = document.querySelector('.game-over');
        if (oldGameOver) {
            oldGameOver.remove();
        }

        const gameOver = document.createElement('div');
        gameOver.className = 'game-over';

        // 檢查是否創造新紀錄
        const isNewRecord = this.score > this.highScore;

        gameOver.innerHTML = `
            <h2>遊戲結束！</h2>
            <p>得分: ${this.score}</p>
            <p>最高分: ${this.highScore}</p>
            ${isNewRecord ? '<p style="color: #ffd700">新紀錄！</p>' : ''}
            <button class="restart-btn">再玩一次</button>
        `;

        this.gameContainer.appendChild(gameOver);

        // 重新開始按鈕監聽
        const restartBtn = gameOver.querySelector('.restart-btn');
        restartBtn.addEventListener('click', () => {
            gameOver.remove();
            this.resetGame();
            this.startGame();
        });
    }

    showMessage(text, duration = 1500) {
        // 移除舊的訊息（如果存在）
        const oldMessage = document.querySelector('.game-message');
        if (oldMessage) {
            oldMessage.remove();
        }

        const message = document.createElement('div');
        message.className = 'game-message';
        message.textContent = text;
        this.gameContainer.appendChild(message);

        setTimeout(() => {
            if (message && message.parentNode) {
                message.remove();
            }
        }, duration);
    }
}

// 確保在頁面加載完成後初始化遊戲
document.addEventListener('DOMContentLoaded', () => {
    window.game = new BasketballGame();
});