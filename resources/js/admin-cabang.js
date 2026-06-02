document.addEventListener("DOMContentLoaded", function() {
    // Styling constants
    const primary = '#33116C';
    const secondary = '#FED50B';
    const tertiary = '#EB3B02';
    const fontHeading = "'Manrope', sans-serif";
    const fontBody = "'Plus Jakarta Sans', sans-serif";
    
    // Default Chart Configs
    Chart.defaults.font.family = fontBody;
    Chart.defaults.color = '#6B7280';
    
    // 1. Sales Trend Line Chart
    const ctxTrend = document.getElementById('salesTrendChart').getContext('2d');
    
    // Create gradient
    let gradient = ctxTrend.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(51, 17, 108, 0.4)');
    gradient.addColorStop(1, 'rgba(51, 17, 108, 0.0)');

    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            datasets: [{
                label: 'Total Penjualan (Juta Rp)',
                data: [150.5, 182.2, 145.8, 205.4],
                borderColor: primary,
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: primary,
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2B2B2B',
                    titleFont: { family: fontHeading, size: 13 },
                    bodyFont: { family: fontBody, size: 13, weight: 'bold' },
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y + ' Juta';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: '600' } }
                },
                y: {
                    grid: { color: '#F3F4F6', drawBorder: false },
                    border: { display: false },
                    ticks: {
                        callback: function(value) { return 'Rp ' + value + 'M'; },
                        font: { weight: '600' }
                    }
                }
            }
        }
    });

    // 2. Category Donut Chart
    const ctxPie = document.getElementById('categoryPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Sembako', 'Snack & Makanan Ringan', 'Minuman', 'Perawatan Diri', 'Lainnya'],
            datasets: [{
                data: [40, 20, 15, 15, 10],
                backgroundColor: [primary, secondary, tertiary, '#4B5563', '#E5E7EB'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { family: fontBody, size: 12, weight: '600' }
                    }
                },
                tooltip: {
                    backgroundColor: '#2B2B2B',
                    titleFont: { family: fontHeading },
                    bodyFont: { family: fontBody, weight: 'bold' },
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed + '% Total Penjualan';
                        }
                    }
                }
            },
            cutout: '75%',
            layout: { padding: { top: 10, bottom: 10 } }
        }
    });
});