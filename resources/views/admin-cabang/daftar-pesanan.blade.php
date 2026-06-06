@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Manajemen Pesanan - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-cabang/daftar-pesanan.css') }}">
@endpush

@section('content')

{{-- ── HEADER ─────────────────────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="page-header-text">
        <h1 class="page-title mb-2">Manajemen Pesanan</h1>
        <p class="page-subtitle text-muted m-0">Kelola dan pantau seluruh transaksi yang masuk ke cabang secara real-time.</p>
    </div>
    <div class="d-flex gap-3">
        <!-- Cetak Rekap deleted as requested -->
    </div>
</div>



{{-- ── KPI CARDS ───────────────────────────────────────────────────────── --}}
<div class="row g-4 mb-5">
    @php
        $kpiItems = [
            ['label'=>'Pesanan Baru',     'val'=>$allCabangOrders->where('status_pesanan','Menunggu')->count(),        'icon'=>'bi-cart-plus',     'class'=>'text-primary-custom', 'bg'=>'bg-primary-light',   'hover'=>'hover-primary'],
            ['label'=>'Sedang Disiapkan', 'val'=>$allCabangOrders->whereIn('status_pesanan', ['Disiapkan', 'diterima_driver', 'diambil'])->count(),       'icon'=>'bi-box-seam',      'class'=>'text-dark',           'bg'=>'bg-secondary-light', 'hover'=>'hover-secondary'],
            ['label'=>'Mencari Kurir',    'val'=>$allCabangOrders->where('status_pesanan','mencari_driver')->count(),   'icon'=>'bi-geo-alt',       'class'=>'text-primary',        'bg'=>'bg-primary-light',   'hover'=>'hover-primary'],
            ['label'=>'Sedang Dikirim',   'val'=>$allCabangOrders->whereIn('status_pesanan', ['dalam_pengiriman', 'diterima'])->count(),  'icon'=>'bi-truck',         'class'=>'text-tertiary-custom','bg'=>'bg-tertiary-light',  'hover'=>'hover-tertiary'],
            ['label'=>'Selesai',          'val'=>$allCabangOrders->where('status_pesanan','selesai')->count(),        'icon'=>'bi-check-circle',  'class'=>'text-success',        'bg'=>'',                   'hover'=>'hover-primary'],
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
                    <option value="mencari_driver" {{ request('status')=='mencari_driver' ? 'selected':'' }}>Mencari Kurir</option>
                    <option value="dalam_pengiriman" {{ request('status')=='dalam_pengiriman' ? 'selected':'' }}>Sedang Dikirim</option>
                    <option value="diterima"       {{ request('status')=='diterima'       ? 'selected':'' }}>Pesanan Tiba</option>
                    <option value="selesai"        {{ request('status')=='selesai'        ? 'selected':'' }}>Selesai</option>
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
                        'Menunggu'         => ['class'=>'status-pending',    'icon'=>'bi-clock',        'label'=>'Menunggu Konfirmasi'],
                        'Disiapkan'        => ['class'=>'status-siap',       'icon'=>'bi-box-seam',     'label'=>'Disiapkan'],
                        'mencari_driver'   => ['class'=>'status-cari-driver','icon'=>'bi-geo-alt-fill', 'label'=>'Mencari Kurir'],
                        'diterima_driver'  => ['class'=>'status-siap',       'icon'=>'bi-person-check', 'label'=>'Diterima Driver'],
                        'diambil'          => ['class'=>'status-siap',       'icon'=>'bi-box-seam',     'label'=>'Diambil Driver'],
                        'dalam_pengiriman' => ['class'=>'status-dikirim',    'icon'=>'bi-truck',        'label'=>'Dikirim'],
                        'diterima'         => ['class'=>'status-pending',    'icon'=>'bi-geo-alt',      'label'=>'Pesanan Tiba'],
                        'selesai'          => ['class'=>'status-selesai',    'icon'=>'bi-check-circle', 'label'=>'Selesai'],
                        'gagal'            => ['class'=>'status-pending',    'icon'=>'bi-exclamation-circle', 'label'=>'Gagal Kirim'],
                        'ditolak_driver'   => ['class'=>'status-pending',    'icon'=>'bi-x-circle',     'label'=>'Ditolak Driver'],
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
                        @if($pesanan->status_pesanan === 'mencari_driver')
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

                            @elseif($pesanan->status_pesanan === 'mencari_driver')
                                {{-- Batalkan dispatch --}}
                                <form action="{{ route('admin-cabang.pesanan.cancel-dispatch', $pesanan->id_pesanan) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Batalkan pencarian driver untuk pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="btn-cancel" title="Batalkan Pencarian Driver">
                                        <i class="bi bi-x-lg me-1"></i>Batalkan
                                    </button>
                                </form>

                            @elseif(in_array($pesanan->status_pesanan, ['dalam_pengiriman', 'diterima']))
                                {{-- Selesaikan manual (override oleh admin) --}}
                                <form action="{{ route('admin-cabang.pesanan.complete', $pesanan->id_pesanan) }}" method="POST" class="d-inline"
                                       onsubmit="return confirm('Selesaikan pesanan ini secara manual?')">
                                    @csrf
                                    <button type="submit" class="btn-confirm" style="background:#10B981;" title="Selesaikan Pesanan">
                                        <i class="bi bi-check-circle me-1"></i>Selesaikan
                                    </button>
                                </form>

                            @elseif($pesanan->status_pesanan === 'selesai')
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
