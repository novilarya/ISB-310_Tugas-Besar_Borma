@extends('layouts.pelanggan')

@section('title', 'Daftar Pesanan Saya')

@section('content')
<div class="pb-10 max-w-4xl mx-auto">

    <!-- Header Section -->
    <div class="mb-8 relative flex items-center justify-between">
        <div>
            <h2 class="font-heading font-extrabold text-3xl text-neutral-800 uppercase tracking-tight">Pesanan Saya</h2>
            <div class="w-16 h-1.5 bg-secondary-400 mt-3 rounded-full"></div>
        </div>
        <a href="{{ route('pelanggan.profil') }}" class="inline-flex items-center gap-2 text-sm font-bold text-primary-700 hover:text-primary-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Profil
        </a>
    </div>

    <!-- Shopee-like Status Filter Tab Navbar -->
    <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden mb-6">
        <div class="flex border-b border-neutral-100 overflow-x-auto scrollbar-none">
            @php
                $tabs = [
                    'all' => 'Semua',
                    'menunggu' => 'Menunggu',
                    'disiapkan' => 'Disiapkan',
                    'dalam_pengiriman' => 'Dalam Pengiriman',
                    'diterima' => 'Diterima',
                    'selesai' => 'Selesai'
                ];
            @endphp
            @foreach($tabs as $key => $label)
                <a href="{{ route('pelanggan.pesanan.index', ['status' => $key]) }}" 
                   class="flex-1 min-w-[120px] text-center py-4 px-2 text-sm font-bold border-b-2 transition-all duration-200 {{ $activeTab === $key ? 'border-primary-700 text-primary-700 bg-primary-50/30' : 'border-transparent text-neutral-500 hover:text-neutral-800 hover:bg-neutral-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Orders List Container -->
    <div class="space-y-4">
        @forelse($pesanans as $pesanan)
            @php
                $statusMap = [
                    'Menunggu' => ['label' => 'Menunggu', 'class' => 'bg-neutral-900 border-neutral-900 text-white'],
                    'Disiapkan' => ['label' => 'Sedang Disiapkan', 'class' => 'bg-blue-50 border-blue-200 text-blue-700'],
                    'mencari_driver' => ['label' => 'Mencari Driver', 'class' => 'bg-purple-50 border-purple-200 text-purple-700'],
                    'diterima_driver' => ['label' => 'Driver Ditemukan', 'class' => 'bg-purple-50 border-purple-200 text-purple-700'],
                    'diambil' => ['label' => 'Pesanan Diambil Driver', 'class' => 'bg-indigo-50 border-indigo-200 text-indigo-700'],
                    'dalam_pengiriman' => ['label' => 'Dalam Pengiriman', 'class' => 'bg-indigo-600 border-indigo-700 text-white'],
                    'diterima' => ['label' => 'Diterima (Kurir Tiba)', 'class' => 'bg-emerald-50 border-emerald-200 text-emerald-700'],
                    'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-100 border-green-200 text-green-800'],
                    'gagal' => ['label' => 'Gagal Kirim', 'class' => 'bg-red-50 border-red-200 text-red-700'],
                    'ditolak_driver' => ['label' => 'Ditolak', 'class' => 'bg-red-50 border-red-200 text-red-700'],
                ];
                $statusInfo = $statusMap[$pesanan->status_pesanan] ?? ['label' => $pesanan->status_pesanan, 'class' => 'bg-neutral-50 border-neutral-200 text-neutral-700'];
            @endphp
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden hover:shadow transition-shadow duration-300">
                <!-- Card Header: Cabang & Status -->
                <div class="px-5 py-4 bg-neutral-50 border-b border-neutral-100 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="font-extrabold text-sm text-neutral-700 uppercase tracking-wide">{{ $pesanan->cabang ? $pesanan->cabang->nama_cabang : 'Borma Toserba' }}</span>
                    </div>
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase border {{ $statusInfo['class'] }} shadow-sm">
                        {{ $statusInfo['label'] }}
                    </span>
                </div>

                <!-- Card Body: Products list -->
                <div class="p-5 divide-y divide-neutral-100">
                    @foreach($pesanan->details as $detail)
                        @php
                            $prodName = $detail->produk ? $detail->produk->nama_produk : 'Produk Borma';
                            $prodImg = $detail->produk ? $detail->produk->gambar_produk : 'default.jpg';
                            $qty = $detail->jumlah;
                            $price = (float)$detail->harga_satuan;
                        @endphp
                        <div class="flex gap-4 py-4 first:pt-0 last:pb-0">
                            <div class="w-16 h-16 bg-neutral-50 border border-neutral-200 rounded-xl overflow-hidden shrink-0 flex items-center justify-center">
                                <img src="/assets/products/{{ $prodImg }}" alt="{{ $prodName }}" class="w-full h-full object-cover" onerror="this.src='/assets/products/default.jpg'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-neutral-800 text-sm truncate">{{ $prodName }}</h4>
                                <p class="text-xs text-neutral-400 mt-1">Jumlah: {{ $qty }} x Rp {{ number_format($price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="font-extrabold text-sm text-neutral-800">Rp {{ number_format($price * $qty, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Card Footer: Total & Actions -->
                <div class="px-5 py-4 bg-neutral-50/50 border-t border-neutral-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="text-xs text-neutral-400 font-medium">
                        Tanggal: {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->translatedFormat('d F Y, H:i') }}
                    </div>
                    <div class="flex items-center gap-4 self-end sm:self-auto">
                        <div class="text-right">
                            <span class="text-xs text-neutral-400">Total Pesanan:</span>
                            <span class="block font-extrabold text-lg text-primary-700">Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="showOrderDetail({{ json_encode($pesanan) }})" class="bg-white border border-neutral-200 text-neutral-700 hover:bg-neutral-50 hover:border-neutral-300 text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm active:scale-95 duration-200">
                                Detail Pesanan
                            </button>
                            @if($pesanan->status_pesanan === 'diterima')
                                <button onclick="confirmOrderFromList({{ $pesanan->id_pesanan }})" class="bg-gradient-to-r from-emerald-600 to-green-500 hover:from-emerald-700 hover:to-green-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-md active:scale-95 duration-200">
                                    Konfirmasi Selesai
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="py-16 flex flex-col items-center justify-center text-center bg-white rounded-2xl border border-neutral-200 shadow-sm p-8">
                <div class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center text-neutral-300 mb-4 border border-dashed border-neutral-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h4 class="font-bold text-neutral-800 mb-1 text-lg">Belum Ada Pesanan</h4>
                <p class="text-sm text-neutral-500 max-w-sm">Tidak ditemukan transaksi dengan status ini. Silakan belanja produk menarik di katalog kami!</p>
                <a href="{{ route('pelanggan.katalog') }}" class="mt-6 bg-primary-700 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-primary-600 transition-colors shadow-md active:scale-95 duration-200">Mulai Belanja</a>
            </div>
        @endforelse
    </div>

    <!-- Modal Detail Pesanan (Identik dengan di profil untuk menjaga fungsi live map & bukti pengiriman) -->
    <div id="orderDetailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-neutral-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeOrderDetailModal()"></div>

            <div class="inline-block align-middle bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full border border-neutral-200 relative z-10">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-primary-800 to-primary-700 px-6 py-4 flex justify-between items-center text-white">
                    <div>
                        <h3 class="font-heading font-extrabold text-lg uppercase tracking-wider" id="modal-title">Detail Pesanan</h3>
                        <p class="text-xs text-primary-200 mt-0.5" id="modalOrderDate">Tanggal Pemesanan: -</p>
                    </div>
                    <button onclick="closeOrderDetailModal()" class="text-white/85 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    <!-- Status & ID -->
                    <div class="grid grid-cols-2 gap-4 bg-neutral-50 rounded-2xl p-4 border border-neutral-200">
                        <div>
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">ID Pesanan</p>
                            <p class="text-sm font-bold text-neutral-800" id="modalOrderId">-</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Status Pesanan</p>
                            <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold uppercase text-white shadow-sm" id="modalOrderStatusBadge">
                                -
                            </span>
                        </div>
                    </div>

                    <!-- Payment & Address -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Metode Pembayaran</p>
                            <p class="text-sm font-bold text-neutral-700" id="modalOrderPayment">-</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Alamat Pengiriman</p>
                            <p class="text-sm text-neutral-600 leading-relaxed font-medium" id="modalOrderAddress">-</p>
                        </div>
                    </div>

                    <!-- Live Tracking Map Section -->
                    <div id="modalOrderMapSection" class="hidden border border-neutral-200 rounded-2xl p-4 bg-neutral-50/50 space-y-2">
                        <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider">Live Tracking Lokasi Kurir</p>
                        <div id="modalOrderMap" style="height: 240px; border-radius: 12px; border: 1.5px solid #E4E0EE; overflow: hidden; z-index: 1;"></div>
                        <div class="flex gap-4 mt-2 px-1 text-[10px] font-bold text-neutral-500 uppercase tracking-wide">
                            <div class="flex items-center gap-1.5">
                                <span style="background: #33116C; width: 8px; height: 8px; border-radius: 50%; display: inline-block;"></span>
                                Gudang/Cabang
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span style="background: #EB3B02; width: 8px; height: 8px; border-radius: 50%; display: inline-block;"></span>
                                Lokasi Anda
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Pengiriman Section -->
                    <div id="modalOrderProofSection" class="hidden bg-green-50/50 rounded-2xl p-4 border border-green-100 space-y-4">
                        <p class="text-[10px] text-green-700 font-bold uppercase tracking-wider">Bukti Pengiriman Selesai</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="w-full h-40 bg-neutral-100 rounded-xl overflow-hidden border border-neutral-200 flex items-center justify-center">
                                <img id="modalOrderProofImg" src="" alt="Bukti Pengiriman" class="w-full h-full object-cover">
                            </div>
                            <div class="flex flex-col justify-center space-y-3">
                                <div>
                                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-0.5">Nama Penerima</p>
                                    <p class="text-sm font-bold text-neutral-800" id="modalOrderProofReceiver">-</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-0.5">Catatan Driver</p>
                                    <p class="text-xs italic text-neutral-600 font-medium" id="modalOrderProofNote">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-neutral-200">

                    <!-- Product Items -->
                    <div>
                        <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-3">Item Belanja</p>
                        <div class="space-y-3" id="modalOrderItemsContainer">
                            <!-- Items will be injected here -->
                        </div>
                    </div>

                    <hr class="border-neutral-200">

                    <!-- Financial Summary -->
                    <div class="space-y-2 bg-neutral-50 rounded-2xl p-4 border border-neutral-200 text-sm">
                        <div class="flex justify-between text-neutral-600 font-medium">
                            <span>Subtotal Belanja</span>
                            <span id="modalOrderSubtotal">Rp -</span>
                        </div>
                        <div class="flex justify-between text-neutral-600 font-medium">
                            <span>Ongkos Kirim</span>
                            <span id="modalOrderShipping">Rp -</span>
                        </div>
                        <div class="flex justify-between text-neutral-600 font-medium">
                            <span>Diskon Voucher</span>
                            <span id="modalOrderDiscount">Rp -</span>
                        </div>
                        <div class="flex justify-between text-neutral-800 font-extrabold border-t border-neutral-200 pt-2 text-base">
                            <span>Total Tagihan</span>
                            <span class="text-primary-700" id="modalOrderTotal">Rp -</span>
                        </div>
                    </div>

                    <!-- Customer Confirmation Action Button -->
                    <div id="modalOrderConfirmActionSection" class="hidden mt-6">
                        <button type="button" onclick="confirmOrderReceived()" class="w-full bg-gradient-to-r from-emerald-600 to-green-500 hover:from-emerald-700 hover:to-green-600 text-white font-heading font-extrabold py-4 px-6 rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-md transition-all duration-200 flex items-center justify-center gap-3 text-sm uppercase tracking-wider border border-emerald-500/20">
                            <svg class="w-5 h-5 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Konfirmasi Pesanan Selesai</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let trackingMapInstance = null;
let currentPesananId = null;

function showOrderDetail(pesanan) {
    currentPesananId = pesanan.id_pesanan;
    document.getElementById('modalOrderId').textContent = pesanan.id_pesanan;
    
    const date = new Date(pesanan.tanggal_pemesanan);
    const options = { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('modalOrderDate').textContent = 'Tanggal Pemesanan: ' + date.toLocaleDateString('id-ID', options);
    
    document.getElementById('modalOrderPayment').textContent = pesanan.metode_pembayaran;
    document.getElementById('modalOrderAddress').textContent = pesanan.alamat_pengiriman;
    
    const status = pesanan.status_pesanan;
    const badge = document.getElementById('modalOrderStatusBadge');
    
    const statusMap = {
        'Menunggu': { label: 'MENUNGGU', class: ['bg-neutral-900', 'border-neutral-900', 'text-white'] },
        'Disiapkan': { label: 'SEDANG DISIAPKAN', class: ['bg-blue-50', 'border-blue-200', 'text-blue-700'] },
        'mencari_driver': { label: 'MENCARI DRIVER', class: ['bg-purple-50', 'border-purple-200', 'text-purple-700'] },
        'diterima_driver': { label: 'DRIVER DITEMUKAN', class: ['bg-purple-50', 'border-purple-200', 'text-purple-700'] },
        'diambil': { label: 'PESANAN DIAMBIL DRIVER', class: ['bg-indigo-50', 'border-indigo-200', 'text-indigo-700'] },
        'dalam_pengiriman': { label: 'DALAM PENGIRIMAN', class: ['bg-indigo-600', 'border-indigo-700', 'text-white'] },
        'diterima': { label: 'DITERIMA (KURIR TIBA)', class: ['bg-emerald-50', 'border-emerald-200', 'text-emerald-700'] },
        'selesai': { label: 'SELESAI', class: ['bg-green-100', 'border-green-200', 'text-green-800'] },
        'gagal': { label: 'GAGAL KIRIM', class: ['bg-red-50', 'border-red-200', 'text-red-700'] },
        'ditolak_driver': { label: 'DITOLAK', class: ['bg-red-50', 'border-red-200', 'text-red-700'] },
    };
    
    const info = statusMap[status] || { label: status.toUpperCase(), class: ['bg-neutral-50', 'border-neutral-200', 'text-neutral-700'] };
    badge.textContent = info.label;
    badge.className = "inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold uppercase border shadow-sm " + info.class.join(' ');
    
    const container = document.getElementById('modalOrderItemsContainer');
    container.innerHTML = '';
    
    if (pesanan.details && pesanan.details.length > 0) {
        pesanan.details.forEach(detail => {
            const prodName = detail.produk ? detail.produk.nama_produk : 'Produk Borma';
            const prodImg = detail.produk ? detail.produk.gambar_produk : 'default.jpg';
            const qty = detail.jumlah;
            const price = parseFloat(detail.harga_satuan);
            const sub = parseFloat(detail.subtotal);
            
            const itemHtml = `
                <div class="flex items-center gap-4 py-2.5 border-b border-neutral-100 last:border-0">
                    <div class="w-12 h-12 bg-neutral-100 rounded-lg shrink-0 overflow-hidden border border-neutral-200 flex items-center justify-center">
                        <img src="/assets/products/${prodImg}" alt="${prodName}" class="w-full h-full object-cover" onerror="this.src='/assets/products/default.jpg'">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-neutral-800 truncate">${prodName}</p>
                        <p class="text-xs text-neutral-500 font-medium">${qty} x Rp ${price.toLocaleString('id-ID')}</p>
                    </div>
                    <p class="text-sm font-extrabold text-neutral-800">Rp ${sub.toLocaleString('id-ID')}</p>
                </div>
            `;
            container.innerHTML += itemHtml;
        });
    } else {
        container.innerHTML = '<p class="text-xs text-neutral-400 italic">Tidak ada item belanja.</p>';
    }
    
    const subtotal = parseFloat(pesanan.total_belanja);
    const shipping = parseFloat(pesanan.biaya_pengiriman);
    const discount = parseFloat(pesanan.diskon_voucher || 0);
    const total = parseFloat(pesanan.total_tagihan);
    
    document.getElementById('modalOrderSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('modalOrderShipping').textContent = 'Rp ' + shipping.toLocaleString('id-ID');
    document.getElementById('modalOrderDiscount').textContent = 'Rp ' + discount.toLocaleString('id-ID');
    document.getElementById('modalOrderTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    
    // Reset Sections
    const mapSection = document.getElementById('modalOrderMapSection');
    const proofSection = document.getElementById('modalOrderProofSection');
    mapSection.classList.add('hidden');
    proofSection.classList.add('hidden');
    
    if (trackingMapInstance) {
        trackingMapInstance.remove();
        trackingMapInstance = null;
    }
    
    // Live Map if status is dalam_pengiriman
    if (status === 'dalam_pengiriman') {
        mapSection.classList.remove('hidden');
        
        let cabangLat = -6.9147;
        let cabangLng = 107.6542;
        let cabangName = 'Gudang Borma';
        if (pesanan.cabang) {
            cabangName = pesanan.cabang.nama_cabang || 'Gudang Borma';
            if (pesanan.cabang.koordinat_gps) {
                const coords = pesanan.cabang.koordinat_gps.split(',');
                if (coords.length === 2) {
                    cabangLat = parseFloat(coords[0].trim());
                    cabangLng = parseFloat(coords[1].trim());
                }
            }
        }
        
        let custLat = pesanan.latitude ? parseFloat(pesanan.latitude) : -6.9215;
        let custLng = pesanan.longitude ? parseFloat(pesanan.longitude) : 107.6310;
        
        const centerLat = (cabangLat + custLat) / 2;
        const centerLng = (cabangLng + custLng) / 2;
        
        // Initialize Map inside modal
        trackingMapInstance = L.map('modalOrderMap', {
            zoomControl: true,
            attributionControl: false
        }).setView([centerLat, centerLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(trackingMapInstance);
        
        const gudangIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #33116C; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(51,17,108,0.4); border: 2.5px solid white;">
                    <svg width="12" height="12" fill="white" viewBox="0 0 16 16"><path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/></svg>
                   </div>`,
            iconSize: [28, 28],
            iconAnchor: [14, 14]
        });

        const customerIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #EB3B02; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(235,59,2,0.4); border: 2.5px solid white;">
                    <svg width="12" height="12" fill="white" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                   </div>`,
            iconSize: [28, 28],
            iconAnchor: [14, 28]
        });
        
        L.marker([cabangLat, cabangLng], { icon: gudangIcon }).addTo(trackingMapInstance)
            .bindPopup('<b>Gudang ' + cabangName + '</b>');

        L.marker([custLat, custLng], { icon: customerIcon }).addTo(trackingMapInstance)
            .bindPopup('<b>Lokasi Anda</b><br>' + pesanan.alamat_pengiriman);
            
        L.polyline([
            [cabangLat, cabangLng],
            [custLat, custLng]
        ], {
            color: '#33116C',
            weight: 3,
            opacity: 0.7,
            dashArray: '6, 6',
            lineCap: 'round'
        }).addTo(trackingMapInstance);
        
        const bounds = L.latLngBounds([
            [cabangLat, cabangLng],
            [custLat, custLng]
        ]);
        trackingMapInstance.fitBounds(bounds, { padding: [20, 20] });
        
        setTimeout(() => {
            if (trackingMapInstance) {
                trackingMapInstance.invalidateSize();
            }
        }, 400);
    }
    
    const confirmActionSection = document.getElementById('modalOrderConfirmActionSection');
    if (confirmActionSection) {
        confirmActionSection.classList.add('hidden');
    }
    
    // Proof of Delivery if status is diterima or selesai
    if (status === 'diterima' || status === 'selesai') {
        proofSection.classList.remove('hidden');
        const img = document.getElementById('modalOrderProofImg');
        if (pesanan.bukti_pengiriman) {
            img.src = '/storage/' + pesanan.bukti_pengiriman;
            img.style.display = 'block';
        } else {
            img.src = '/assets/products/default.jpg';
        }
        document.getElementById('modalOrderProofReceiver').textContent = pesanan.nama_penerima || 'Penerima tidak dicatat';
        document.getElementById('modalOrderProofNote').textContent = pesanan.catatan_driver ? '"' + pesanan.catatan_driver + '"' : 'Tidak ada catatan driver';
    }

    if (status === 'diterima' && confirmActionSection) {
        confirmActionSection.classList.remove('hidden');
    }
    
    document.getElementById('orderDetailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeOrderDetailModal() {
    document.getElementById('orderDetailModal').classList.add('hidden');
    document.body.style.overflow = '';
    if (trackingMapInstance) {
        trackingMapInstance.remove();
        trackingMapInstance = null;
    }
}

function confirmOrderReceived() {
    if (!currentPesananId) return;
    confirmOrderFromList(currentPesananId);
}

function confirmOrderFromList(pesananId) {
    if (!confirm('Apakah Anda yakin ingin mengkonfirmasi bahwa pesanan ini telah selesai diterima?')) return;
    
    const url = `/pelanggan/pesanan/${pesananId}/confirm-received`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || 'Gagal mengkonfirmasi pesanan.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>
@endpush
