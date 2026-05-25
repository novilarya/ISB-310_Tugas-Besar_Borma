@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Manajemen Pesanan - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
/* ── Status Badges ─────────────────────────────── */
.status-badge-modern { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 0.73rem; font-weight: 800; white-space: nowrap; }
.status-pending   { background: #FFF8E1; color: #92400E; }
.status-siap      { background: #EDE9FE; color: #5B21B6; }
.status-cari-driver { background: #E0F2FE; color: #0369A1; }
.status-dikirim   { background: #F0FDF4; color: #166534; }
.status-selesai   { background: #ECFDF5; color: #065F46; }

/* ── Mencari Kurir Animation ─────────────────── */
@keyframes pulse-ring {
    0%   { transform: scale(0.8); opacity: 0.8; }
    70%  { transform: scale(1.4); opacity: 0; }
    100% { transform: scale(1.4); opacity: 0; }
}
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

.driver-searching {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #EFF6FF;
    border: 1px solid #BFDBFE;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 800;
    color: #1D4ED8;
    position: relative;
}
.driver-searching .spin-icon {
    animation: spin 1s linear infinite;
    font-size: 0.9rem;
}

/* ── Tombol Aksi ─────────────────────────────── */
.btn-confirm   { background: #33116C; color: white; border: none; padding: 5px 14px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; cursor: pointer; transition: 0.2s; }
.btn-confirm:hover { background: #4C1D95; }
.btn-dispatch  { background: #FED50B; color: #33116C; border: none; padding: 5px 14px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; cursor: pointer; transition: 0.2s; }
.btn-dispatch:hover { background: #EAB308; }
.btn-cancel    { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; padding: 5px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 700; cursor: pointer; }
.btn-nota      { background: transparent; border: none; color: #6B7280; cursor: pointer; padding: 4px 6px; border-radius: 6px; transition: 0.2s; }
.btn-nota:hover { background: #F3F4F6; color: #33116C; }

/* ── Confirmation Modal ──────────────────────── */
.modal-confirm-body { max-height: 60vh; overflow-y: auto; }
.confirm-item-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F3F4F6; font-size: 0.85rem; }
.confirm-item-row:last-child { border-bottom: none; }
.confirm-total { font-size: 1rem; font-weight: 800; color: #33116C; }
</style>
@endpush

@section('content')

{{-- ── HEADER ─────────────────────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-end mb-4">
    <div style="max-width: 600px;">
        <h1 class="page-title mb-2">Manajemen Pesanan</h1>
        <p class="page-subtitle">Kelola dan pantau seluruh transaksi yang masuk ke cabang secara real-time.</p>
    </div>
    <div class="d-flex gap-3">
        <!-- Cetak Rekap deleted as requested -->
    </div>
</div>

{{-- ── FLASH MESSAGES ─────────────────────────────────────────────────── --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:12px;border:none;font-weight:600;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:12px;border:none;font-weight:600;">
    <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ── KPI CARDS ───────────────────────────────────────────────────────── --}}
<div class="row g-4 mb-5">
    @php
        $kpiItems = [
            ['label'=>'Pesanan Baru',     'val'=>$allCabangOrders->where('status_pesanan','Menunggu')->count(),        'icon'=>'bi-cart-plus',     'class'=>'text-primary-custom', 'bg'=>'bg-primary-light',   'hover'=>'hover-primary'],
            ['label'=>'Sedang Disiapkan', 'val'=>$allCabangOrders->where('status_pesanan','Disiapkan')->count(),       'icon'=>'bi-box-seam',      'class'=>'text-dark',           'bg'=>'bg-secondary-light', 'hover'=>'hover-secondary'],
            ['label'=>'Mencari Kurir',    'val'=>$allCabangOrders->where('status_pesanan','Mencari Kurir')->count(),   'icon'=>'bi-geo-alt',       'class'=>'text-primary',        'bg'=>'bg-primary-light',   'hover'=>'hover-primary'],
            ['label'=>'Sedang Dikirim',   'val'=>$allCabangOrders->where('status_pesanan','Sedang Dikirim')->count(),  'icon'=>'bi-truck',         'class'=>'text-tertiary-custom','bg'=>'bg-tertiary-light',  'hover'=>'hover-tertiary'],
            ['label'=>'Selesai',          'val'=>$allCabangOrders->where('status_pesanan','Diterima')->count(),        'icon'=>'bi-check-circle',  'class'=>'text-success',        'bg'=>'',                   'hover'=>'hover-primary'],
        ];
    @endphp
    @foreach($kpiItems as $kpi)
    <div class="col">
        <div class="glass-card h-100 kpi-card-interactive {{ $kpi['hover'] }}">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title {{ $kpi['class'] }}">{{ $kpi['label'] }}</div>
                <div class="icon-box-md icon-box-rounded {{ $kpi['bg'] }} d-flex align-items-center justify-content-center">
                    <i class="bi {{ $kpi['icon'] }} {{ $kpi['class'] }} icon-lg"></i>
                </div>
            </div>
            <div class="kpi-value-lg m-0 {{ $kpi['class'] }}" style="font-weight:800;">{{ $kpi['val'] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- ── FILTER BAR ──────────────────────────────────────────────────────── --}}
<div class="mb-5">
    <div class="glass-card mb-4" style="padding: 16px 24px;">
        <form action="{{ route('admin-cabang.pesanan') }}" method="GET" class="row g-3 w-100 align-items-center m-0">
            <div class="col-md-4 ps-0">
                <div class="search-input w-100">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pelanggan atau ID pesanan..." class="w-100">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select filter-select-lg w-100" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Menunggu"       {{ request('status')=='Menunggu'       ? 'selected':'' }}>Menunggu Konfirmasi</option>
                    <option value="Disiapkan"      {{ request('status')=='Disiapkan'      ? 'selected':'' }}>Sedang Disiapkan</option>
                    <option value="Mencari Kurir" {{ request('status')=='Mencari Kurir' ? 'selected':'' }}>Mencari Kurir</option>
                    <option value="Sedang Dikirim" {{ request('status')=='Sedang Dikirim' ? 'selected':'' }}>Sedang Dikirim</option>
                    <option value="Diterima"       {{ request('status')=='Diterima'       ? 'selected':'' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px; border: 1px solid #E5E7EB; border-right: none; height: 42px;"><i class="bi bi-calendar3"></i></span>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control border-start-0" style="border-radius: 0 8px 8px 0; border: 1px solid #E5E7EB; font-weight: 700; height: 42px; color: var(--borma-neutral);" onchange="this.form.submit()">
                </div>
            </div>
            <div class="col-md-1 pe-0 text-end">
                <a href="{{ route('admin-cabang.pesanan') }}" class="btn-action btn-action-outline w-100 d-flex justify-content-center align-items-center" style="height: 42px;" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- ── TABEL PESANAN ─────────────────────────────────────────────── --}}
    <div class="table-produk">
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort'=>'id_pesanan','direction'=>request('direction')=='asc'?'desc':'asc']) }}" class="text-primary-custom text-decoration-none">
                            Pesanan @if(request('sort')=='id_pesanan')<i class="bi bi-sort-{{ request('direction')=='asc'?'up':'down' }}"></i>@endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort'=>'tanggal_pemesanan','direction'=>request('direction')=='asc'?'desc':'asc']) }}" class="text-primary-custom text-decoration-none">
                            Waktu @if(request('sort')=='tanggal_pemesanan')<i class="bi bi-sort-{{ request('direction')=='asc'?'up':'down' }}"></i>@endif
                        </a>
                    </th>
                    <th>Pelanggan</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort'=>'total_tagihan','direction'=>request('direction')=='asc'?'desc':'asc']) }}" class="text-primary-custom text-decoration-none">
                            Tagihan @if(request('sort')=='total_tagihan')<i class="bi bi-sort-{{ request('direction')=='asc'?'up':'down' }}"></i>@endif
                        </a>
                    </th>
                    <th>Driver / Pengiriman</th>
                    <th>Status</th>
                    <th style="min-width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                @php
                    $statusMap = [
                        'Menunggu'       => ['class'=>'status-pending',    'icon'=>'bi-clock',        'label'=>'Menunggu'],
                        'Disiapkan'      => ['class'=>'status-siap',       'icon'=>'bi-box-seam',     'label'=>'Disiapkan'],
                        'Mencari Kurir'  => ['class'=>'status-cari-driver','icon'=>'bi-geo-alt-fill', 'label'=>'Mencari Kurir'],
                        'Sedang Dikirim' => ['class'=>'status-dikirim',    'icon'=>'bi-truck',        'label'=>'Dikirim'],
                        'Diterima'       => ['class'=>'status-selesai',    'icon'=>'bi-check-circle', 'label'=>'Selesai'],
                    ];
                    $st = $statusMap[$pesanan->status_pesanan] ?? ['class'=>'status-pending','icon'=>'bi-question','label'=>$pesanan->status_pesanan];
                    $oid = '#BRM-9' . str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT);
                @endphp
                <tr>
                    {{-- ID --}}
                    <td>
                        <a href="{{ route('admin-cabang.pesanan.show', $pesanan->id_pesanan) }}"
                           style="font-weight:800;color:var(--borma-primary);font-family:var(--font-heading);letter-spacing:0.5px;text-decoration:none;">
                            {{ $oid }}
                        </a>
                    </td>
                    {{-- Waktu --}}
                    <td>
                        <div style="font-weight:700;">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->isToday() ? 'Hari ini' : \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y') }}</div>
                        <div class="text-muted" style="font-size:0.78rem;">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('H:i') }} WIB</div>
                    </td>
                    {{-- Pelanggan --}}
                    <td>
                        <div style="font-weight:800;">{{ $pesanan->pelanggan->user->nama ?? '-' }}</div>
                    </td>
                    {{-- Tagihan --}}
                    <td>
                        <div style="font-weight:800;color:var(--borma-tertiary);font-size:1rem;">Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</div>
                    </td>
                    {{-- Driver --}}
                    <td>
                        @if($pesanan->kurir)
                            <div style="font-weight:700;font-size:0.82rem;"><i class="bi bi-person-fill me-1 text-primary-custom"></i>{{ $pesanan->kurir->user->nama ?? '-' }}</div>
                        @else
                            <span class="text-muted" style="font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    {{-- Status --}}
                    <td>
                        @if($pesanan->status_pesanan === 'Mencari Kurir')
                            <div class="driver-searching">
                                <i class="bi bi-arrow-repeat spin-icon"></i>
                                Mencari Kurir...
                            </div>
                        @else
                            <span class="status-badge-modern {{ $st['class'] }}">
                                {{ $st['label'] }}
                            </span>
                        @endif
                    </td>
                    {{-- AKSI --}}
                    <td>
                        <div class="d-flex align-items-center gap-2 flex-wrap">

                            {{-- 👁 Lihat Detail --}}
                            <a href="{{ route('admin-cabang.pesanan.show', $pesanan->id_pesanan) }}"
                               class="btn-nota" title="Lihat Detail">
                                <i class="bi bi-eye" style="font-size:1rem;"></i>
                            </a>

                            {{-- 🖨 Cetak Nota --}}
                            <a href="{{ route('admin-cabang.pesanan.nota', $pesanan->id_pesanan) }}"
                               target="_blank" class="btn-nota" title="Cetak Nota / Resi">
                                <i class="bi bi-printer" style="font-size:1rem;"></i>
                            </a>

                            {{-- STATUS ACTIONS --}}
                            @if($pesanan->status_pesanan === 'Menunggu')
                                {{-- Konfirmasi → buka modal detail dulu --}}
                                <button class="btn-confirm"
                                    onclick="bukaModalKonfirmasi({{ $pesanan->id_pesanan }}, '{{ $oid }}')"
                                    title="Konfirmasi Pesanan">
                                    <i class="bi bi-check-lg me-1"></i>Konfirmasi
                                </button>

                            @elseif($pesanan->status_pesanan === 'Disiapkan')
                                {{-- Antar → dispatch driver --}}
                                <form action="{{ route('admin-cabang.pesanan.dispatch', $pesanan->id_pesanan) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Cari dan kirim driver untuk pesanan {{ $oid }}?')">
                                    @csrf
                                    <button type="submit" class="btn-dispatch" title="Cari Driver & Kirim">
                                        <i class="bi bi-truck me-1"></i>Antar
                                    </button>
                                </form>

                            @elseif($pesanan->status_pesanan === 'Mencari Kurir')
                                {{-- Batalkan dispatch --}}
                                <form action="{{ route('admin-cabang.pesanan.cancel-dispatch', $pesanan->id_pesanan) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Batalkan pencarian driver untuk pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="btn-cancel" title="Batalkan Pencarian Driver">
                                        <i class="bi bi-x-lg me-1"></i>Batalkan
                                    </button>
                                </form>

                            @elseif($pesanan->status_pesanan === 'Sedang Dikirim')
                                {{-- Selesaikan manual (override oleh admin) --}}
                                <form action="{{ route('admin-cabang.pesanan.complete', $pesanan->id_pesanan) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tandai pesanan ini sudah diterima?')">
                                    @csrf
                                    <button type="submit" class="btn-confirm" style="background:#10B981;" title="Tandai Selesai">
                                        <i class="bi bi-check-circle me-1"></i>Selesai
                                    </button>
                                </form>

                            @elseif($pesanan->status_pesanan === 'Diterima')
                                <span class="text-success" style="font-size:0.78rem;font-weight:700;">
                                    <i class="bi bi-check-circle-fill me-1"></i>Selesai
                                </span>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size:2.5rem;opacity:0.3;display:block;margin-bottom:8px;"></i>
                        Belum ada pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-custom mt-4 mb-2 px-3">
            <span class="text-muted me-auto pagination-info">
                Menampilkan {{ $pesanans->firstItem() ?? 0 }}–{{ $pesanans->lastItem() ?? 0 }} dari {{ $pesanans->total() }} pesanan
            </span>
            <div class="pagination-links-styled">
                {{ $pesanans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════
     MODAL KONFIRMASI PESANAN
     Muncul sebelum admin menekan tombol "Konfirmasi" di server
 ══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius:20px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.12);">

      <div class="modal-header" style="border-bottom:1px dashed #E5E7EB;padding:20px 28px;">
        <div>
            <h5 class="modal-title text-primary-custom" style="font-weight:800;" id="modalKonfirmasiTitle">
                Konfirmasi Pesanan
            </h5>
            <p class="text-muted m-0" style="font-size:0.82rem;">Periksa detail pesanan sebelum mengkonfirmasi</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body modal-confirm-body" style="padding:24px 28px;" id="modalKonfirmasiBody">
        {{-- Diisi oleh JavaScript --}}
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Memuat detail pesanan...</p>
        </div>
      </div>

      <div class="modal-footer" style="border-top:1px dashed #E5E7EB;padding:16px 28px;gap:12px;">
        <button type="button" class="btn-action btn-action-outline" data-bs-dismiss="modal">Periksa Lagi</button>
        <form id="formKonfirmasi" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn-action btn-action-primary">
                <i class="bi bi-check-lg me-2"></i>Ya, Konfirmasi Pesanan
            </button>
        </form>
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin-cabang.js') }}"></script>
<script>
// ── Modal Konfirmasi Pesanan ──────────────────────────────────────────────
async function bukaModalKonfirmasi(orderId, orderLabel) {
    // Reset modal
    document.getElementById('modalKonfirmasiTitle').textContent = 'Konfirmasi Pesanan ' + orderLabel;
    document.getElementById('modalKonfirmasiBody').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted small">Memuat detail pesanan...</p>
        </div>`;
    document.getElementById('formKonfirmasi').action = `/admin-cabang/pesanan/${orderId}/confirm`;

    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
    modal.show();

    // Fetch data pesanan
    try {
        const res  = await fetch(`/admin-cabang/pesanan/${orderId}/json`);
        const data = await res.json();

        let itemsHtml = data.items.map(item => `
            <div class="confirm-item-row">
                <div>
                    <div style="font-weight:700;">${item.nama}</div>
                    <div style="font-size:0.78rem;color:#9CA3AF;">${item.jumlah} × ${item.harga_fmt}</div>
                </div>
                <div style="font-weight:800;color:var(--borma-primary);">${item.sub_fmt}</div>
            </div>`).join('');

        document.getElementById('modalKonfirmasiBody').innerHTML = `
            <div class="row g-4">
                <div class="col-md-6">
                    <div style="font-size:0.72rem;font-weight:800;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Informasi Pelanggan</div>
                    <div style="font-weight:800;font-size:0.95rem;">${data.customer}</div>
                    <div style="font-size:0.82rem;color:#6B7280;"><i class="bi bi-telephone me-1"></i>${data.phone}</div>
                    <div style="font-size:0.82rem;color:#6B7280;margin-top:4px;"><i class="bi bi-calendar me-1"></i>${data.tanggal}</div>
                </div>
                <div class="col-md-6">
                    <div style="font-size:0.72rem;font-weight:800;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Pengiriman</div>
                    <div style="font-size:0.82rem;color:#374151;font-weight:600;">${data.alamat}</div>
                    <div style="margin-top:8px;">
                        <span class="badge-modern badge-primary" style="font-size:0.72rem;">
                            <i class="bi bi-credit-card me-1"></i>${data.metode}
                        </span>
                    </div>
                </div>
            </div>

            <hr style="border:1px dashed #E5E7EB;margin:16px 0;">

            <div style="font-size:0.72rem;font-weight:800;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">
                Daftar Produk (${data.items.length} item)
            </div>
            ${itemsHtml}

            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:14px;padding-top:14px;border-top:2px solid #F3F4F6;">
                <span style="font-size:0.85rem;color:#6B7280;font-weight:600;">Total Tagihan</span>
                <span class="confirm-total">${data.total_fmt}</span>
            </div>`;
    } catch (e) {
        document.getElementById('modalKonfirmasiBody').innerHTML = `
            <div class="alert alert-danger">Gagal memuat detail pesanan. Coba lagi.</div>`;
    }
}
</script>
@endpush
