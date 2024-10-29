function showFloor(floorId) {
    const image = document.getElementById('currentImage');
    const restaurantName = document.getElementById('restaurantName');
    const description = document.getElementById('floorDescription');

    if (floorId === 'floor1') {
        image.src = 'https://hips.hearstapps.com/hmg-prod/images/2-horz-1524627668.jpg?crop=1.00xw:0.956xh;0,0&resize=1200:*'; // 替換為中式餐廳圖片
        restaurantName.textContent = '第一樓 - 中式餐廳';
        description.textContent = '這家中式餐廳提供正宗的餃子和炒飯，是家庭聚餐的最佳選擇！';
    } else if (floorId === 'floor2') {
        image.src = 'https://hips.hearstapps.com/hmg-prod/images/tk-seafood-steak-2-1515496852.jpg?crop=1xw:1xh;center,top&resize=980:*'; // 替換為西式餐廳圖片
        restaurantName.textContent = '第二樓 - 西式餐廳';
        description.textContent = '這裡的漢堡和披薩口味獨特，深受年輕人的喜愛！';
    } else if (floorId === 'floor3') {
        image.src = 'https://hips.hearstapps.com/hmg-prod/images/c1-1635995297.jpg?crop=1.00xw:1.00xh;0,0&resize=1200:*'; // 替換為甜點店圖片
        restaurantName.textContent = '第三樓 - 甜點店';
        description.textContent = '專賣各式精緻甜點，讓每位甜食愛好者都能找到心頭好！';
    }
}

function submitForm(event) {
    event.preventDefault(); // 防止表單提交的默認行為
    const confirmationMessage = document.getElementById('confirmationMessage');
    confirmationMessage.style.display = 'block'; // 顯示預約確認信息
    document.getElementById('form').reset(); // 重置表單
}
