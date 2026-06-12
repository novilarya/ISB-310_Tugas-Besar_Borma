document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('kategoriStokChart');
    if (!ctx) return;

    const rootStyle = getComputedStyle(document.documentElement);
    const bormaPrimary = rootStyle.getPropertyValue('--borma-primary').trim() || '#33116C';
    const bormaSecondary = rootStyle.getPropertyValue('--borma-secondary').trim() || '#FED50B';
    const bormaTertiary = rootStyle.getPropertyValue('--borma-tertiary').trim() || '#EB3B02';

    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? 'rgba(255, 255, 255, 0.7)' : '#6B7280';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0,0,0,0.04)';

    // Parse data attributes
    const kategoriLabels = JSON.parse(ctx.dataset.labels || '[]');
    const kategoriStok   = JSON.parse(ctx.dataset.stok || '[]');
    const kategoriSku    = JSON.parse(ctx.dataset.sku || '[]');

    const colors = [
        bormaPrimary, bormaSecondary, bormaTertiary, '#6366F1',
        '#10B981', '#F59E0B', '#3B82F6', '#EC4899'
    ];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: kategoriLabels.length ? kategoriLabels : ['Belum ada data'],
            datasets: [{
                label: 'Total Stok',
                data: kategoriStok.length ? kategoriStok : [0],
                backgroundColor: colors.slice(0, kategoriLabels.length),
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: (items) => items[0].label,
                        label: (context) => {
                            const idx = context.dataIndex;
                            return [
                                ' Stok: ' + context.parsed.y.toLocaleString('id-ID') + ' unit',
                                ' SKU : ' + (kategoriSku[idx] ?? 0) + ' produk'
                            ];
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: {
                        font: { size: 11, weight: '700' },
                        color: textColor
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        display: false,
                        font: { size: 11, weight: '700' },
                        color: textColor
                    }
                }
            }
        }
    });
});
