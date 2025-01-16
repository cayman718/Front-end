// 財務計算機物件
const financialPlanner = {
    // 基本設定
    settings: {
        conservativeReturn: { min: 0.03, max: 0.05 },
        moderateReturn: { min: 0.06, max: 0.08 },
        aggressiveReturn: { min: 0.09, max: 0.12 },
        lifeExpectancy: 85
    },

    // 計算每月總收入
    calculateMonthlyIncome(salary, extraIncome) {
        return salary + extraIncome;
    },

    // 計算每月總支出
    calculateMonthlyExpenses(basicExpenses, extraExpenses) {
        return basicExpenses + extraExpenses;
    },

    // 計算每月儲蓄
    calculateMonthlySaving(totalIncome, totalExpenses) {
        return totalIncome - totalExpenses;
    },

    // 計算通膨調整後的金額
    calculateInflationAdjusted(amount, years, inflationRate) {
        return amount * Math.pow(1 + inflationRate, years);
    },

    // 計算投資組合增長
    calculatePortfolioGrowth(data) {
        let {
            currentSaving,
            monthlySaving,
            yearsToRetirement,
            returnRate,
            inflationRate
        } = data;

        let portfolio = [];
        let balance = currentSaving;
        let annualSaving = monthlySaving * 12;

        for (let year = 1; year <= yearsToRetirement; year++) {
            // 考慮通膨調整後的年度儲蓄
            let inflationAdjustedSaving = this.calculateInflationAdjusted(
                annualSaving,
                year - 1,
                inflationRate
            );

            // 投資報酬 + 年度儲蓄
            balance = balance * (1 + returnRate) + inflationAdjustedSaving;

            portfolio.push({
                year: year,
                balance: Math.round(balance),
                savingAmount: Math.round(inflationAdjustedSaving)
            });
        }

        return portfolio;
    },

    // 生成財務報告
    generateFinancialReport(formData) {
        // 計算基本數據
        const monthlyIncome = this.calculateMonthlyIncome(
            Number(formData.monthlySalary),
            Number(formData.monthlyExtraIncome)
        );

        const monthlyExpenses = this.calculateMonthlyExpenses(
            Number(formData.monthlyBasicExpenses),
            Number(formData.monthlyExtraExpenses)
        );

        const monthlySaving = this.calculateMonthlySaving(
            monthlyIncome,
            monthlyExpenses
        );

        // 計算退休相關數據
        const yearsToRetirement = formData.retirementAge - formData.age;
        const retirementYears = this.settings.lifeExpectancy - formData.retirementAge;
        const inflationRate = Number(formData.inflationRate) / 100;

        // 決定投資報酬率範圍
        let returnRateRange;
        switch (formData.riskTolerance) {
            case 'conservative':
                returnRateRange = this.settings.conservativeReturn;
                break;
            case 'moderate':
                returnRateRange = this.settings.moderateReturn;
                break;
            case 'aggressive':
                returnRateRange = this.settings.aggressiveReturn;
                break;
        }

        // 使用報酬率範圍的平均值
        const returnRate = (returnRateRange.min + returnRateRange.max) / 2;

        // 計算投資組合增長
        const portfolio = this.calculatePortfolioGrowth({
            currentSaving: Number(formData.currentSaving),
            monthlySaving,
            yearsToRetirement,
            returnRate,
            inflationRate
        });

        // 計算通膨調整後的目標金額
        const inflationAdjustedTarget = this.calculateInflationAdjusted(
            Number(formData.targetAmount),
            yearsToRetirement,
            inflationRate
        );

        return {
            basicInfo: {
                name: formData.name,
                age: formData.age,
                retirementAge: formData.retirementAge,
                yearsToRetirement,
                retirementYears
            },
            monthlyFlow: {
                income: monthlyIncome,
                expenses: monthlyExpenses,
                saving: monthlySaving
            },
            retirement: {
                currentSaving: formData.currentSaving,
                targetAmount: formData.targetAmount,
                inflationAdjustedTarget,
                returnRate,
                inflationRate
            },
            portfolio
        };
    }
};

// 處理表單提交
document.getElementById('financialForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // 獲取表單數據
    const formData = {
        name: document.getElementById('name').value,
        age: Number(document.getElementById('age').value),
        retirementAge: Number(document.getElementById('retirementAge').value),
        monthlySalary: document.getElementById('monthlySalary').value,
        monthlyExtraIncome: document.getElementById('monthlyExtraIncome').value,
        monthlyBasicExpenses: document.getElementById('monthlyBasicExpenses').value,
        monthlyExtraExpenses: document.getElementById('monthlyExtraExpenses').value,
        currentSaving: document.getElementById('currentSaving').value,
        targetAmount: document.getElementById('targetAmount').value,
        riskTolerance: document.getElementById('riskTolerance').value,
        inflationRate: document.getElementById('inflationRate').value
    };

    // 生成報告
    const report = financialPlanner.generateFinancialReport(formData);

    // 顯示結果
    displayResults(report);
});

// 顯示結果函數
function displayResults(report) {
    // 顯示結果卡片
    document.getElementById('resultCard').style.display = 'block';

    // 更新基本資訊
    document.getElementById('basicInfoContent').innerHTML = `
        <ul class="list-group">
            <li class="list-group-item">姓名：${report.basicInfo.name}</li>
            <li class="list-group-item">目前年齡：${report.basicInfo.age} 歲</li>
            <li class="list-group-item">預計退休年齡：${report.basicInfo.retirementAge} 歲</li>
            <li class="list-group-item">距離退休：${report.basicInfo.yearsToRetirement} 年</li>
            <li class="list-group-item">預期退休後生活：${report.basicInfo.retirementYears} 年</li>
        </ul>
    `;

    // 更新每月收支
    document.getElementById('monthlyFlowContent').innerHTML = `
        <ul class="list-group">
            <li class="list-group-item">月收入：${report.monthlyFlow.income.toLocaleString()} 元</li>
            <li class="list-group-item">月支出：${report.monthlyFlow.expenses.toLocaleString()} 元</li>
            <li class="list-group-item">每月儲蓄：${report.monthlyFlow.saving.toLocaleString()} 元</li>
            <li class="list-group-item">年度儲蓄：${(report.monthlyFlow.saving * 12).toLocaleString()} 元</li>
        </ul>
    `;

    // 更新退休規劃
    document.getElementById('retirementPlanContent').innerHTML = `
        <ul class="list-group">
            <li class="list-group-item">目前存款：${Number(report.retirement.currentSaving).toLocaleString()} 元</li>
            <li class="list-group-item">目標退休金：${Number(report.retirement.targetAmount).toLocaleString()} 元</li>
            <li class="list-group-item">考慮通膨後的目標金額：${Math.round(report.retirement.inflationAdjustedTarget).toLocaleString()} 元</li>
            <li class="list-group-item">預期年投資報酬率：${(report.retirement.returnRate * 100).toFixed(1)}%</li>
            <li class="list-group-item">預期年通膨率：${(report.retirement.inflationRate * 100).toFixed(1)}%</li>
        </ul>
    `;

    // 更新通膨影響
    const inflationImpact = report.retirement.inflationAdjustedTarget - report.retirement.targetAmount;
    document.getElementById('inflationImpactContent').innerHTML = `
        <div class="alert alert-info">
            <p>由於通貨膨脹的影響，您的退休目標金額將需要增加 ${Math.round(inflationImpact).toLocaleString()} 元</p>
            <p>原始目標：${Number(report.retirement.targetAmount).toLocaleString()} 元</p>
            <p>通膨調整後：${Math.round(report.retirement.inflationAdjustedTarget).toLocaleString()} 元</p>
        </div>
    `;

    // 更新年度預估
    let projectionHtml = '<div class="table-responsive"><table class="table">';
    projectionHtml += '<thead><tr><th>年度</th><th>年度儲蓄</th><th>累計金額</th><th>達成率</th></tr></thead><tbody>';

    report.portfolio.forEach(year => {
        const progressPercent = (year.balance / report.retirement.inflationAdjustedTarget * 100).toFixed(1);
        projectionHtml += `
            <tr>
                <td>第 ${year.year} 年</td>
                <td>${year.savingAmount.toLocaleString()} 元</td>
                <td>${year.balance.toLocaleString()} 元</td>
                <td>${progressPercent}%</td>
            </tr>
        `;
    });

    projectionHtml += '</tbody></table></div>';
    document.getElementById('yearlyProjectionContent').innerHTML = projectionHtml;

    // 更新建議
    const finalBalance = report.portfolio[report.portfolio.length - 1].balance;
    let suggestionsHtml = '';

    if (finalBalance >= report.retirement.inflationAdjustedTarget) {
        suggestionsHtml = `
            <div class="alert alert-success">
                <h5>恭喜！按照目前規劃，您的退休金額將超過通膨調整後的目標。</h5>
                <p>預估退休時的資產：${finalBalance.toLocaleString()} 元</p>
                <p>超出目標：${(finalBalance - report.retirement.inflationAdjustedTarget).toLocaleString()} 元</p>
            </div>
        `;
    } else {
        suggestionsHtml = `
            <div class="alert alert-warning">
                <h5>警告：目前的儲蓄計畫可能不足以達到退休目標。</h5>
                <p>差距：${(report.retirement.inflationAdjustedTarget - finalBalance).toLocaleString()} 元</p>
                <h6>建議：</h6>
                <ul>
                    <li>增加每月儲蓄（目前：${report.monthlyFlow.saving.toLocaleString()} 元）</li>
                    <li>考慮提高投資報酬率（目前：${(report.retirement.returnRate * 100).toFixed(1)}%）</li>
                    <li>延後退休年齡（目前：${report.basicInfo.retirementAge} 歲）</li>
                    <li>降低退休後的預期支出</li>
                    <li>尋找額外收入來源</li>
                </ul>
            </div>
        `;
    }

    document.getElementById('suggestionsContent').innerHTML = suggestionsHtml;

    // 繪製圖表
    createWealthProjectionChart(report);
}

// 繪製財富預估圖表
function createWealthProjectionChart(report) {
    const ctx = document.getElementById('wealthProjectionChart').getContext('2d');

    // 準備圖表數據
    const labels = report.portfolio.map(item => `第 ${item.year} 年`);
    const balanceData = report.portfolio.map(item => item.balance);
    const targetLine = new Array(report.portfolio.length).fill(report.retirement.inflationAdjustedTarget);

    // 如果已存在圖表，先銷毀
    if (window.wealthChart) {
        window.wealthChart.destroy();
    }

    // 創建新圖表
    window.wealthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                    label: '預估資產',
                    data: balanceData,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                {
                    label: '目標金額',
                    data: targetLine,
                    borderColor: 'rgb(255, 99, 132)',
                    borderDash: [5, 5],
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: '財富累積預估圖'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: '金額 (元)'
                    }
                }
            }
        }
    });
}