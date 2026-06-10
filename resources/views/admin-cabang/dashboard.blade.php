@extends('admin-cabang.layouts.admin-cabang')

@section('title', 'Dashboard - Admin Cabang')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="page-header-text">
        <h1 class="page-title mb-2">Dashboard Cabang</h1>
        <p class="page-subtitle text-muted m-0">Ringkasan performa & operasional Borma Toserba hari ini.</p>
    </div>
    <div class="d-flex gap-3">
        <!-- Export PDF deleted as requested -->
    </div>
</div>

<!-- KPI Cards -->
<div class="row g-4 mb-5">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="glass-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="kpi-title">Total Penjualan</div>
                <div class="icon-box bg-primary-light"><i class="bi bi-wallet2"></i></div>
            </div>
            <div class="kpi-value">Rp {{ number_format($monthlySales, 0, ',', '.') }}</div>
            <div class="kpi-sub">
                <span>Hari ini: <strong class="text-success">+Rp {{ number_format($todaySales, 0, ',', '.') }}</strong></span>
                <span>Minggu ini: <strong>Rp {{ number_format($weeklySales, 0, ',', '.') }}</strong></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="glass-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="kpi-title">Status Pesanan</div>
                <div class="icon-box bg-secondary-light"><i class="bi bi-box-seam"></i></div>
            </div>
            <div class="kpi-value">{{ number_format($allOrders->count(), 0, ',', '.') }}</div>
            <div class="kpi-sub">
                <span>Pending: <strong class="text-warning">{{ $pendingOrders }}</strong></span>
                <span>Diproses: <strong class="text-primary-custom">{{ $processOrders }}</strong></span>
                <span>Selesai: <strong class="text-success">{{ $completedOrders }}</strong></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="glass-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="kpi-title">Info Produk</div>
                <div class="icon-box bg-tertiary-light"><i class="bi bi-tags"></i></div>
            </div>
            <div class="kpi-value">{{ number_format($produkCabangs->count(), 0, ',', '.') }}</div>
            <div class="kpi-sub">
                <span>Stok Terbanyak: <strong>{{ $produkCabangs->count() > 0 ? ($produkCabangs->sortByDesc('jumlah_stok')->first()->produk->nama_produk ?? '-') : '-' }}</strong></span>
                <span>Stok Tipis: <strong class="text-tertiary-custom">{{ $produkCabangs->where('jumlah_stok', '<', 20)->count() }} item</strong></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-6">
        <div class="glass-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="kpi-title">Member Plus</div>
                <div class="icon-box bg-primary-light"><i class="bi bi-people"></i></div>
            </div>
            <div class="kpi-value">{{ number_format($totalCustomers, 0, ',', '.') }}</div>
            <div class="kpi-sub">
                <span>Minggu ini: <strong class="text-success">+{{ $memberMingguIni }} Member Plus</strong></span>
                <span>Top User: <strong>{{ $topMembers->first()->nama ?? '-' }}</strong></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-xl-6">
        <div class="glass-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="kpi-title">Performa Voucher</div>
                <div class="icon-box bg-secondary-light"><i class="bi bi-ticket-perforated"></i></div>
            </div>
            @php $voucherPercentage = $promoQuota > 0 ? round(($promoDigunakan / $promoQuota) * 100) : 0; @endphp
            <div class="kpi-value">{{ $voucherPercentage }}%</div>
            <div class="kpi-sub">
                <span>Total Kuota: <strong>{{ number_format($promoQuota, 0, ',', '.') }}</strong></span>
                <span>Digunakan: <strong class="text-success">{{ number_format($promoDigunakan, 0, ',', '.') }}</strong></span>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="kpi-title m-0">Trend Penjualan (7 Hari Terakhir)</h6>
                <span class="badge-modern badge-primary">Real-time</span>
            </div>
            <div class="chart-container" style="height: 350px;">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access -->
<div class="mb-5">
    <h6 class="kpi-title mb-4">Akses Cepat</h6>
    <div class="quick-access-grid">
        <a href="{{ route('admin-cabang.pesanan') }}" class="qa-card">
            <i class="bi bi-card-list"></i>
            <span>Daftar Pesanan</span>
        </a>
        <a href="{{ route('admin-cabang.produk') }}" class="qa-card alt">
            <i class="bi bi-box"></i>
            <span>Manajemen Produk</span>
        </a>
        <a href="{{ route('admin-cabang.promo') }}" class="qa-card">
            <i class="bi bi-ticket-perforated"></i>
            <span>Promo & Voucher</span>
        </a>
        <a href="{{ route('admin-cabang.member') }}" class="qa-card alt">
            <i class="bi bi-person-lines-fill"></i>
            <span>Manajemen Member</span>
        </a>
        <a href="{{ route('admin-cabang.laporan') }}" class="qa-card">
            <i class="bi bi-bar-chart-line"></i>
            <span>Laporan</span>
        </a>
    </div>
</div>

<!-- Details Area -->
<div class="row g-4 mb-5">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Recent Orders -->
        <div class="glass-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="kpi-title m-0">Ringkasan Pesanan Terbaru</h6>
                <a href="{{ route('admin-cabang.pesanan') }}" class="text-primary-custom link-see-all">LIHAT SEMUA →</a>
            </div>
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total Belanja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesananTerbaru as $order)
                    <tr>
                        <td><strong>#BRM-9{{ str_pad($order->id_pesanan, 3, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $order->pelanggan->user->nama ?? 'Pelanggan Borma' }}</td>
                        <td><strong>Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}</strong></td>
                        <td>
                            @php
                                $statusMap = [
                                    'Menunggu'         => ['class' => 'badge-modern badge-warning', 'label' => 'Menunggu Konfirmasi'],
                                    'Disiapkan'        => ['class' => 'badge-modern badge-primary', 'label' => 'Disiapkan'],
                                    'mencari_driver'   => ['class' => 'badge-modern badge-info', 'label' => 'Mencari Kurir'],
                                    'diterima_driver'  => ['class' => 'badge-modern badge-primary', 'label' => 'Diterima Driver'],
                                    'diambil'          => ['class' => 'badge-modern badge-primary', 'label' => 'Diambil Driver'],
                                    'dalam_pengiriman' => ['class' => 'badge-modern badge-info', 'label' => 'Dalam Pengiriman'],
                                    'diterima'         => ['class' => 'badge-modern badge-warning', 'label' => 'Pesanan Tiba'],
                                    'selesai'          => ['class' => 'badge-modern badge-success', 'label' => 'Selesai'],
                                    'gagal'            => ['class' => 'badge-modern badge-danger', 'label' => 'Gagal'],
                                    'ditolak_driver'   => ['class' => 'badge-modern badge-danger', 'label' => 'Ditolak Driver'],
                                ];
                                $st = $statusMap[$order->status_pesanan] ?? ['class' => 'badge-modern badge-secondary', 'label' => $order->status_pesanan];
                            @endphp
                            <span class="{{ $st['class'] }}">{{ $st['label'] }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin-cabang.pesanan.show', $order->id_pesanan) }}" class="btn-action btn-action-outline">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada pesanan terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Member Insights -->
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="kpi-title m-0">Member Insights</h6>
                <i class="bi bi-info-circle text-muted"></i>
            </div>
            <div class="row">
                <div class="col-md-6 pe-4 border-end border-light">
                    <p class="text-muted mb-4" class="list-title-sm">Top Spender Member Plus</p>
                    @forelse($topMembers as $index => $member)
                    <div class="list-item-modern">
                        <div class="icon-box {{ $index === 0 ? 'bg-secondary-light' : 'bg-primary-light' }} icon-box-rounded"><i class="bi bi-person"></i></div>
                        <div class="info">
                            <h6>{{ $member->nama }}</h6>
                            <small>{{ $member->total_transaksi }} Transaksi</small>
                        </div>
                        <div class="value">Rp {{ number_format($member->total_spent, 0, ',', '.') }}</div>
                    </div>
                    @empty
                    <p class="text-muted small">Belum ada data transaksi member plus.</p>
                    @endforelse
                </div>
                <div class="col-md-6 ps-4">
                    <p class="text-muted mb-4" class="list-title-sm">Penggunaan Poin & Reward</p>
                    <div class="reward-card mb-3">
                        <span class="reward-label">Total Diskon Diberikan</span>
                        <strong class="reward-value-lg text-primary-custom">Rp {{ number_format($totalDiskon, 0, ',', '.') }}</strong>
                    </div>
                    <div class="reward-card mb-3">
                        <span class="reward-label">Promo Transaksi</span>
                        <strong class="text-success reward-value-sm">{{ $promoDigunakan }} Digunakan</strong>
                    </div>
                    <div class="reward-card">
                        <span class="reward-label">Gratis Ongkir</span>
                        <strong class="text-success reward-value-sm">{{ $totalGratisOngkir }} Digunakan</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Top Kategori Terjual -->
        <div class="glass-card mb-4">
            <h6 class="kpi-title mb-4">Top Kategori Terjual</h6>
            <div class="chart-container" style="height: 280px;">
                <canvas id="categoryPieChart"></canvas>
            </div>
        </div>

        <!-- Produk Highlights -->
        <div class="glass-card mb-4">
            <h6 class="kpi-title mb-4">Produk Highlights</h6>
            
            <p class="text-muted mb-3" class="list-title-sm">Top Terlaris</p>
            @forelse($topTerlaris as $product)
            <div class="list-item-modern {{ $loop->last ? 'mb-4 border-bottom-0 pb-0' : '' }}">
                @if(!empty($product->produk->gambar_produk) && $product->produk->gambar_produk !== 'default.jpg')
                    <img src="{{ asset('storage/produk/' . $product->produk->gambar_produk) }}" alt="{{ $product->produk->nama_produk }}" class="icon-box" style="object-fit: cover; border-radius: 8px;">
                @else
                    <div class="icon-box bg-light text-muted" style="border-radius: 8px;"><i class="bi bi-image"></i></div>
                @endif
                <div class="info">
                    <h6>{{ $product->produk->nama_produk ?? '-' }}</h6>
                    <small>{{ number_format($product->jumlah_terjual ?? 0, 0, ',', '.') }} terjual · Stok: {{ $product->jumlah_stok }}</small>
                </div>
                <a href="{{ route('admin-cabang.promo') }}" class="btn-action btn-action-outline btn-action-sm">Promo</a>
            </div>
            @empty
            <p class="text-muted small">Belum ada data penjualan.</p>
            @endforelse

            <hr class="divider-custom">

            <p class="text-muted mb-3" class="list-title-sm text-tertiary-custom">Peringatan Stok Habis</p>
            @forelse($produkStokTipis->take(2) as $product)
            <div class="list-item-modern {{ $loop->last ? 'border-bottom-0 pb-0' : '' }}">
                @if(!empty($product->produk->gambar_produk) && $product->produk->gambar_produk !== 'default.jpg')
                    <img src="{{ asset('storage/produk/' . $product->produk->gambar_produk) }}" alt="{{ $product->produk->nama_produk }}" class="icon-box" style="object-fit: cover; border-radius: 8px;">
                @else
                    <div class="icon-box bg-light text-muted" style="border-radius: 8px;"><i class="bi bi-image"></i></div>
                @endif
                <div class="info">
                    <h6>{{ $product->produk->nama_produk ?? '-' }}</h6>
                    <small class="text-tertiary-custom fw-bold">Sisa {{ $product->jumlah_stok }} pcs</small>
                </div>
                <a href="{{ route('admin-cabang.produk') }}" class="btn-action btn-action-primary btn-action-sm" title="Update stok produk ini">
                    Update
                </a>
            </div>
            @empty
            <p class="text-success small mb-0"><i class="bi bi-check-circle-fill me-1"></i>Stok aman.</p>
            @endforelse
        </div>
        
        <!-- Footer / Contact -->
        <div class="glass-card footer-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="kpi-title m-0" >Informasi Cabang</h6>
                <i class="bi bi-shop text-secondary-custom icon-xl"></i>
            </div>
            <div class="mb-4">
                <h5 class="mb-2 footer-title">{{ $cabangInfo->nama_cabang ?? 'Borma' }}</h5>
                <p class="footer-text">{{ $cabangInfo->alamat_cabang ?? 'Alamat Cabang' }}</p>
            </div>
            <div class="d-flex flex-column gap-3 pagination-info">
                <div class="d-flex align-items-center">
                    <div class="footer-icon-box">
                        <i class="bi bi-telephone-fill text-secondary-custom"></i>
                    </div>
                    {{ auth()->user()->no_telepon ?? '-' }}
                </div>
                <div class="d-flex align-items-center">
                    <div class="footer-icon-box">
                        <i class="bi bi-envelope-fill text-secondary-custom"></i>
                    </div>
                    {{ auth()->user()->email ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('js/admin-cabang.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const rootStyle = getComputedStyle(document.documentElement);
    const bormaPrimary = rootStyle.getPropertyValue('--borma-primary').trim() || '#33116C';
    const bormaSecondary = rootStyle.getPropertyValue('--borma-secondary').trim() || '#FED50B';
    const bormaTertiary = rootStyle.getPropertyValue('--borma-tertiary').trim() || '#EB3B02';

    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? 'rgba(255, 255, 255, 0.7)' : '#6B7280';
    const pieLegendColor = isDark ? '#ffffff' : '#374151';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0,0,0,0.04)';

    // ── Trend Penjualan 7 Hari ──────────────────────────────────────
    const salesLabels = @json($chartLabels);
    const salesData   = @json($chartData);

    const ctxSales = document.getElementById('salesTrendChart').getContext('2d');
    const salesGrad = ctxSales.createLinearGradient(0, 0, 0, 280);
    
    let primaryRgb = '51, 17, 108'; // Default
    if (bormaPrimary.startsWith('#')) {
        let hex = bormaPrimary.replace('#', '');
        if (hex.length === 3) {
            hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
        }
        if (hex.length === 6) {
            const r = parseInt(hex.substring(0, 2), 16);
            const g = parseInt(hex.substring(2, 4), 16);
            const b = parseInt(hex.substring(4, 6), 16);
            primaryRgb = `${r}, ${g}, ${b}`;
        }
    }
    salesGrad.addColorStop(0, `rgba(${primaryRgb}, 0.15)`);
    salesGrad.addColorStop(1, `rgba(${primaryRgb}, 0)`);

    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: salesData,
                borderColor: bormaPrimary,
                backgroundColor: salesGrad,
                borderWidth: 2.5,
                pointBackgroundColor: bormaSecondary,
                pointBorderColor: bormaPrimary,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: {
                        callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000).toFixed(1)+'jt' : (v/1000).toFixed(0)+'rb'),
                        font: { size: 11, weight: '700' },
                        color: textColor
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '700' }, color: textColor }
                }
            }
        }
    });

    // ── Pie Chart Kategori ──────────────────────────────────────────
    const pieLabels = @json($pieLabels);
    const pieData   = @json($pieData);

    const pieColors = [bormaPrimary, bormaSecondary, bormaTertiary, '#6366F1', '#10B981'];

    const ctxPie = document.getElementById('categoryPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: pieLabels.length ? pieLabels : ['Belum ada data'],
            datasets: [{
                data: pieData.length ? pieData : [1],
                backgroundColor: pieColors,
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 11, weight: '700' }, color: pieLegendColor, padding: 12, boxWidth: 12 }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ' Rp ' + ctx.parsed.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

});
</script>
@endpush