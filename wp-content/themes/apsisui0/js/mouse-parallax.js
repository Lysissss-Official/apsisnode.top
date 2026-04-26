document.addEventListener('DOMContentLoaded', function() {
    const bgElement = document.querySelector('.header-image');
    const titleElement = document.querySelector('#header-page-title-inside');

    if (!bgElement || !titleElement) return;
    
    // 强制背景放大，防止露边
    //bgElement.style.backgroundSize = 'auto 105%';

    // 获取原始 background-position 作为基准
    const computedStyle = window.getComputedStyle(bgElement);
    let bgPos = computedStyle.backgroundPosition;
    let baseX = '50%', baseY = '50%';
    if (bgPos && bgPos !== '0% 0%') {
        const parts = bgPos.split(' ');
        baseX = parts[0] || '50%';
        baseY = parts[1] || '50%';
    }

    // 视差强度
    const bgIntensity = 30;     // 背景最大偏移像素
    const titleIntensity = 10;  // 标题最大偏移像素

    // 当前实际位置
    let currentBgX = 0, currentBgY = 0;
    let currentTitleX = 0, currentTitleY = 0;

    // 目标位置（由鼠标位置计算得出）
    let targetBgX = 0, targetBgY = 0;
    let targetTitleX = 0, targetTitleY = 0;

    // 缓动系数（0~1），数值越小惯性越大（移动越慢）
    const easeFactor = 0.1;

    // 动画循环标志
    let rafId = null;

    // 鼠标移动事件
    window.addEventListener('mousemove', function(e) {
        const winWidth = window.innerWidth;
        const winHeight = window.innerHeight;

        // 计算鼠标位置相对于窗口中心的比例 (-0.5 ~ 0.5)
        const mouseX = (e.clientX / winWidth) - 0.5;
        const mouseY = (e.clientY / winHeight) - 0.5;

        // 更新目标位置
        targetBgX = mouseX * bgIntensity;
        targetBgY = mouseY * bgIntensity;
        targetTitleX = -mouseX * titleIntensity;  // 标题反向移动
        targetTitleY = -mouseY * titleIntensity;

        // 如果动画循环尚未启动，则启动
        if (!rafId) {
            rafId = requestAnimationFrame(animate);
        }
    });

    // 鼠标离开窗口时，目标位置归零（慢慢回到原位）
    document.addEventListener('mouseleave', function() {
        targetBgX = 0;
        targetBgY = 0;
        targetTitleX = 0;
        targetTitleY = 0;

        if (!rafId) {
            rafId = requestAnimationFrame(animate);
        }
    });

    // 动画函数
    function animate() {
        // 使用线性插值更新当前位置
        currentBgX += (targetBgX - currentBgX) * easeFactor;
        currentBgY += (targetBgY - currentBgY) * easeFactor;
        currentTitleX += (targetTitleX - currentTitleX) * easeFactor;
        currentTitleY += (targetTitleY - currentTitleY) * easeFactor;

        // 应用背景偏移
        bgElement.style.backgroundPosition = `calc(${baseX} + ${currentBgX}px) calc(${baseY} + ${currentBgY}px)`;

        // 应用标题偏移
        titleElement.style.transform = `translate(${currentTitleX}px, ${currentTitleY}px)`;

        // 判断是否接近目标（允许误差）
        const threshold = 0.01;
        if (Math.abs(currentBgX - targetBgX) > threshold ||
            Math.abs(currentBgY - targetBgY) > threshold ||
            Math.abs(currentTitleX - targetTitleX) > threshold ||
            Math.abs(currentTitleY - targetTitleY) > threshold) {
            // 继续动画
            rafId = requestAnimationFrame(animate);
        } else {
            // 停止动画
            rafId = null;
        }
    }
});