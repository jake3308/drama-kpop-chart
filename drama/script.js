// script.js
document.addEventListener('DOMContentLoaded', () => {
    // Add any JavaScript functionality here for dynamic content loading or navigation
});
function showChart(chartId) {
    // 모든 차트를 숨김
    var charts = document.querySelectorAll('.chart-details');
    charts.forEach(function(chart) {
        chart.classList.remove('active');
    });

    // 선택된 차트만 표시
    var selectedChart = document.getElementById(chartId);
    selectedChart.classList.add('active');
}
