@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Laporan Cabang - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-cabang/laporan-cabang.css') }}">
@endpush

@section('content')

{{-- ════════════════════════════════════════════════════════════
     PRINT HEADER (hanya muncul saat print)
════════════════════════════════════════════════════════════ --}}
<div class="print-only" style="text-align:center; margin-bottom: 24px; border-bottom: 2px solid #33116c; padding-bottom: 16px;">
    <h2 style="color:#33116c; margin:0; font-size:1.4rem;">BORMA TOSERBA</h2>
    <h3 style="margin:4px 0; font-size:1rem;">{{ $cabang->nama_cabang ?? 'Cabang Antapani' }}</h3>
    <p style="margin:0; font-size:.85rem; color:#555;">{{ $cabang->alamat_cabang ?? '' }}</p>
    <h4 style="margin:12px 0 4px; font-size:1.1rem;">LAPORAN PENJUALAN BULANAN</h4>
    <p style="margin:0; font-size:.85rem;">Periode: {{ $daftarBulan[$bulan] }} {{ $tahun }}</p>
    <p style="margin:0; font-size:.8rem; color:#777;">Dicetak: {{ now()->format('d M Y, H:i') }} WIB</p>
</div>

{{-- ════════════════════════════════════════════════════════════
     PAGE HEADER
════════════════════════════════════════════════════════════ --}}
<div class="d-flex justify-content-between align-items-end mb-4 no-print">
    <div class="page-header-text">
        <h1 class="page-title mb-2">Laporan Cabang</h1>
        <p class="page-subtitle text-muted m-0">Pantau kinerja penjualan, produk terlaris, dan kondisi stok cabang.</p>
    </div>
    <div>
        <button onclick="window.print()" class="btn-primary-custom" style="background:var(--borma-tertiary);">
            Cetak Ringkasan Laporan
        </button>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     FILTER PERIODE
════════════════════════════════════════════════════════════ --}}
<div class="glass-card mb-4 no-print" style="padding: 16px 24px;">
    <form action="{{ route('admin-cabang.laporan') }}" method="GET" class="d-flex justify-content-between align-items-center">
        <div class="d-flex gap-4">
            <div>
                <label class="kpi-title" style="font-size: .7rem; margin-bottom: 4px;">BULAN</label>
                <select name="bulan" class="form-select border-0 bg-light" style="font-weight: 700; width: 140px; border-radius: 8px; cursor: pointer;" onchange="this.form.submit()">
                    @foreach($daftarBulan as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="kpi-title" style="font-size: .7rem; margin-bottom: 4px;">TAHUN</label>
                <select name="tahun" class="form-select border-0 bg-light" style="font-weight: 700; width: 120px; border-radius: 8px; cursor: pointer;" onchange="this.form.submit()">
                    @foreach($daftarTahun as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <span style="background:rgba(51,17,108,.08);color:var(--borma-primary);font-size:.85rem;padding:8px 16px;border-radius:8px;font-weight:800;">
                <i class="bi bi-calendar3 me-2"></i> {{ $mulai->format('d M') }} – {{ $akhir->format('d M Y') }}
            </span>
        </div>
    </form>
</div>

{{-- ════════════════════════════════════════════════════════════
     KPI CARDS
════════════════════════════════════════════════════════════ --}}
<div class="row g-4 mb-4 print-row">
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100 kpi-card-interactive hover-primary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="kpi-title">TOTAL PENDAPATAN</div>
                <div class="icon-box bg-primary-light"><i class="bi bi-wallet2 text-primary-custom"></i></div>
            </div>
            <div class="kpi-value" style="color:var(--borma-primary);font-size:1.8rem;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <p class="text-muted mt-auto mb-0" style="font-size:.8rem;font-weight:600;">Dari {{ $pesananSelesai }} pesanan selesai</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100 kpi-card-interactive hover-secondary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="kpi-title">TOTAL PESANAN</div>
                <div class="icon-box bg-secondary-light"><i class="bi bi-cart-check text-secondary-custom"></i></div>
            </div>
            <div class="kpi-value" style="font-size:1.8rem;">{{ $totalPesanan }}</div>
            <p class="text-muted mt-auto mb-0" style="font-size:.8rem;font-weight:600;">{{ $pesananSelesai }} pesanan selesai</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100 kpi-card-interactive hover-tertiary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="kpi-title">RATA-RATA TRANSAKSI</div>
                <div class="icon-box bg-tertiary-light"><i class="bi bi-graph-up text-tertiary-custom"></i></div>
            </div>
            <div class="kpi-value" style="font-size:1.8rem;">Rp {{ number_format($rataTagihan, 0, ',', '.') }}</div>
            <p class="text-muted mt-auto mb-0" style="font-size:.8rem;font-weight:600;">Per transaksi selesai</p>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="glass-card h-100 kpi-card-interactive hover-success">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="kpi-title">TOTAL DISKON DIBERIKAN</div>
                <div class="icon-box" style="background: rgba(5, 150, 105, 0.1);"><i class="bi bi-tag-fill" style="color: #059669;"></i></div>
            </div>
            <div class="kpi-value" style="color:#059669;font-size:1.8rem;">Rp {{ number_format($totalDiskon, 0, ',', '.') }}</div>
            <p class="text-muted mt-auto mb-0" style="font-size:.8rem;font-weight:600;">Total voucher/diskon terpakai</p>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     CHART HARIAN + REKAP STATUS
════════════════════════════════════════════════════════════ --}}
<div class="row g-4 mb-4">
    {{-- Chart Penjualan Harian --}}
    <div class="col-lg-8">
        <div class="glass-card h-100 d-flex flex-column" style="padding: 24px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;">
                <div>
                    <div class="kpi-title mb-1">GRAFIK PENJUALAN HARIAN</div>
                    <div style="font-size:.8rem;color:#6B7280;font-weight:600;">{{ $daftarBulan[$bulan] }} {{ $tahun }}</div>
                </div>
                <div style="font-size:.8rem;font-weight:800;color:var(--borma-primary);">
                    Pendapatan (Rp)
                </div>
            </div>
            @php
                $maxHarian = $penjualanHarian->max('total') ?: 1;
                $daysInMonth = $mulai->daysInMonth;
                $harianMap = $penjualanHarian->keyBy(fn($h) => \Carbon\Carbon::parse($h->tanggal)->day);
            @endphp
            <div class="mt-auto" style="margin-left: -8px; margin-right: -8px;">
                <div class="chart-daily mb-3" style="height: 120px;">
                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php 
                            $h = $harianMap[$d] ?? null; 
                            $height = $h ? round(($h->total/$maxHarian)*100) : 4; 
                            $bg = $h ? 'var(--borma-primary)' : 'var(--chart-empty-bar-bg, #E5E7EB)';
                        @endphp
                        <div class="chart-daily-bar" style="height:{{ $height }}px; background: {{ $bg }}; opacity: 1;">
                            <span class="tooltip-val">{{ $d }}: Rp {{ $h ? number_format($h->total,0,',','.') : '0' }}</span>
                        </div>
                    @endfor
                </div>
                <div style="display:flex;justify-content:space-between;font-size:.65rem;color:#9CA3AF;font-weight:800;padding: 0 8px;">
                    <span>1</span><span>8</span><span>16</span><span>23</span><span>31</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Rekap Status --}}
    <div class="col-lg-4">
        <div class="glass-card h-100" style="padding: 24px;">
            <div class="kpi-title mb-4">REKAP STATUS PESANAN</div>
            <div style="display: flex; flex-direction: column; justify-content: space-between; height: calc(100% - 30px);">
                @foreach(['Menunggu','Disiapkan','dalam_pengiriman','diterima'] as $st)
                @php $r = $rekapStatus[$st] ?? null; @endphp
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @php
                            $badge = ['Menunggu'=>'status-pending','Disiapkan'=>'status-siap','dalam_pengiriman'=>'status-dikirim','diterima'=>'status-selesai'][$st] ?? 'status-pending';
                            $label = $st === 'Menunggu' ? 'MENUNGGU KONFIRMASI' : ($st === 'diterima' ? 'SELESAI' : ($st === 'dalam_pengiriman' ? 'SEDANG DIKIRIM' : mb_strtoupper($st)));
                        @endphp
                        <span class="status-badge-modern {{ $badge }}" style="font-size:.7rem; padding: 6px 14px;">{{ $label }}</span>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-weight:800;font-size:.95rem;color:var(--borma-neutral);">{{ $r ? $r->jumlah : 0 }} pesanan</div>
                        <div style="font-size:.75rem;color:#6B7280;margin-top:2px;">Rp {{ $r ? number_format($r->total,0,',','.') : '0' }}</div>
                    </div>
                </div>
                @if(!$loop->last) <hr style="margin: 14px 0; border-color: #F3F4F6;"> @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     PRODUK TERLARIS + KATEGORI
════════════════════════════════════════════════════════════ --}}
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="glass-card h-100" style="padding: 24px;">
            <div class="kpi-title mb-4">TOP 10 PRODUK TERLARIS</div>
            <div class="d-flex flex-column justify-content-between" style="height: calc(100% - 30px);">
                @php $maxTerjual = $produkTerlaris->max('total_terjual') ?: 1; @endphp
                @forelse($produkTerlaris as $i => $p)
                <div class="chart-bar-h">
                    <span class="label">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;font-size:.65rem;font-weight:800;background:var(--borma-primary);color:white;border-radius:4px;margin-right:8px;">{{ $i+1 }}</span>
                        {{ $p->nama_produk }}
                    </span>
                    <div class="bar-wrap">
                        <div class="bar-fill" style="width:{{ round(($p->total_terjual/$maxTerjual)*100) }}%;background:var(--borma-primary);"></div>
                    </div>
                    <span class="value">{{ $p->total_terjual }} pcs</span>
                </div>
                @empty
                <p class="text-muted text-center py-3">Belum ada data penjualan bulan ini.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="glass-card h-100" style="padding: 24px;">
            <div class="kpi-title mb-4">PENDAPATAN PER KATEGORI</div>
            @php $maxKat = $penjualanKategori->max('total_revenue') ?: 1; @endphp
            @forelse($penjualanKategori as $i => $k)
            <div class="chart-bar-h">
                <span class="label" style="width: 120px;">{{ $k->kategori }}</span>
                <div class="bar-wrap">
                    <div class="bar-fill" style="width:{{ round(($k->total_revenue/$maxKat)*100) }}%;background:var(--borma-primary);"></div>
                </div>
                <span class="value" style="font-size:.7rem;">Rp {{ number_format($k->total_revenue/1000,0,',','.')}}rb</span>
            </div>
            @empty
            <p class="text-muted text-center py-3">Belum ada data.</p>
            @endforelse

            {{-- Stok Kritis --}}
            @if($stokKritis->count() > 0)
            <div style="margin-top:32px;padding-top:24px;border-top:1px solid #F3F4F6;">
                <div class="kpi-title mb-4" style="color:var(--borma-tertiary);">STOK KRITIS</div>
                @foreach($stokKritis->take(5) as $sk)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div style="font-size:.85rem;font-weight:700;color:#374151;">{{ $sk->produk->nama_produk ?? '-' }}</div>
                    <span class="status-badge-modern {{ $sk->jumlah_stok <= 0 ? 'status-siap' : 'status-pending' }}" style="font-size:.65rem; padding: 4px 10px;">
                        {{ $sk->jumlah_stok }} UNIT
                    </span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     TABEL TRANSAKSI LENGKAP (Paginated)
════════════════════════════════════════════════════════════ --}}
<div class="table-produk mt-4 no-print">
    <div style="padding: 20px 24px 8px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <div style="font-family:var(--font-heading);font-weight:800;font-size:1.1rem;color:var(--borma-primary);">
                Rincian Transaksi
            </div>
            <div style="font-size:.85rem;color:#6B7280;">Periode {{ $daftarBulan[$bulan] }} {{ $tahun }}</div>
        </div>
        <a href="{{ route('admin-cabang.laporan.export-csv', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn-primary-custom" style="background:#059669;padding:8px 18px;font-size:.85rem;text-decoration:none;">
            Export CSV
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Item</th>
                <th>Total Belanja</th>
                <th>Diskon</th>
                <th>Total Tagihan</th>
                <th>Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
                @forelse($semuaPesanan as $p)
                 @php
                     $statusMap = [
                         'Menunggu'         => ['class'=>'status-pending',    'label'=>'Menunggu'],
                         'Disiapkan'        => ['class'=>'status-siap',       'label'=>'Disiapkan'],
                         'mencari_driver'   => ['class'=>'status-cari-driver','label'=>'Mencari Kurir'],
                         'diterima_driver'  => ['class'=>'status-siap',       'label'=>'Diterima Driver'],
                         'diambil'          => ['class'=>'status-siap',       'label'=>'Diambil Driver'],
                         'dalam_pengiriman' => ['class'=>'status-dikirim',    'label'=>'Dikirim'],
                         'diterima'         => ['class'=>'status-pending',    'label'=>'Pesanan Tiba'],
                         'selesai'          => ['class'=>'status-selesai',    'label'=>'Selesai'],
                         'gagal'            => ['class'=>'status-pending',    'label'=>'Gagal Kirim'],
                         'ditolak_driver'   => ['class'=>'status-pending',    'label'=>'Ditolak Driver'],
                     ];
                     $st = $statusMap[$p->status_pesanan] ?? ['class'=>'status-pending', 'label'=>$p->status_pesanan];
                 @endphp
                <tr>
                <td><strong style="font-family:monospace;color:var(--borma-primary);">#BRM-9{{ str_pad($p->id_pesanan,3,'0',STR_PAD_LEFT) }}</strong></td>
                <td style="font-size:.8rem;">{{ \Carbon\Carbon::parse($p->tanggal_pemesanan)->format('d M Y H:i') }}</td>
                <td style="font-weight:700;font-size:.85rem;">{{ $p->pelanggan->user->nama ?? '-' }}</td>
                <td style="font-weight:700;text-align:center;">{{ $p->details->sum('jumlah') }}</td>
                <td>Rp {{ number_format($p->total_belanja,0,',','.') }}</td>
                <td style="color:#059669;font-weight:700;">{{ $p->diskon_voucher > 0 ? '-Rp '.number_format($p->diskon_voucher,0,',','.') : '—' }}</td>
                <td style="font-weight:800;color:var(--borma-tertiary);">Rp {{ number_format($p->total_tagihan,0,',','.') }}</td>
                <td style="font-size:.78rem;">{{ $p->metode_pembayaran }}</td>
                <td><span class="status-badge-modern {{ $st['class'] }}" style="font-size:.65rem;">{{ $st['label'] }}</span></td>
            </tr>
                @empty
            <tr>
                <td colspan="9" class="text-center py-4 text-muted">Belum ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="pagination-custom mt-4 mb-2 px-3">
        <span class="text-muted me-auto pagination-info">Menampilkan {{ $semuaPesanan->firstItem() ?? 0 }} - {{ $semuaPesanan->lastItem() ?? 0 }} dari {{ $semuaPesanan->total() }} pesanan</span>
        <div class="pagination-links-styled">
            {{ $semuaPesanan->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
