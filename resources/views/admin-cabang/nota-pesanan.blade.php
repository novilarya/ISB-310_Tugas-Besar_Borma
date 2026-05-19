<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pesanan {{ '#BRM-9' . str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #111;
            background: white;
            padding: 20px;
            max-width: 320px;
            margin: 0 auto;
        }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #999; margin: 8px 0; }
        .divider-solid { border-top: 2px solid #111; margin: 8px 0; }
        .row { display: flex; justify-content: space-between; margin: 3px 0; }
        .row .label { color: #555; }
        .row .value { font-weight: bold; }
        .items-header { display: flex; justify-content: space-between; font-weight: bold; margin: 4px 0; }
        .item-row { margin: 3px 0; }
        .item-name { font-weight: bold; }
        .item-detail { display: flex; justify-content: space-between; color: #444; font-size: 11px; margin-top: 1px; }
        .total-row { display: flex; justify-content: space-between; font-weight: bold; font-size: 13px; }
        .logo-area { margin-bottom: 12px; }
        .logo-area h2 { font-size: 20px; font-weight: 900; letter-spacing: 2px; }
        .logo-area p { font-size: 10px; color: #555; }
        .barcode-area { margin: 12px 0; text-align: center; }
        .order-id { font-size: 16px; font-weight: 900; letter-spacing: 1px; }
        .status-badge {
            display: inline-block;
            padding: 2px 10px;
            border: 1px solid #111;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            margin-top: 4px;
            text-transform: uppercase;
        }
        .footer { margin-top: 16px; text-align: center; font-size: 10px; color: #777; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            @page { margin: 5mm; }
        }
    </style>
</head>
<body>

{{-- ── Header ─────────────────────────────────────────────────────────── --}}
<div class="center logo-area">
    <h2>BORMA</h2>
    <p>Toserba Borma — {{ $pesanan->cabang->nama_cabang ?? 'Antapani' }}</p>
    <p>{{ $pesanan->cabang->alamat ?? 'Jl. Terusan Jakarta No. 53, Bandung' }}</p>
    <p>Telp. {{ $pesanan->cabang->no_telp ?? '(022) 1234567' }}</p>
</div>

<div class="divider-solid"></div>

<div class="center">
    <div class="order-id">#BRM-9{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}</div>
    <div class="status-badge">{{ strtoupper($pesanan->status_pesanan) }}</div>
</div>

<div class="divider"></div>

{{-- ── Info Pesanan ────────────────────────────────────────────────────── --}}
<div class="row">
    <span class="label">Tanggal</span>
    <span class="value">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d/m/Y H:i') }}</span>
</div>
<div class="row">
    <span class="label">Pelanggan</span>
    <span class="value">{{ $pesanan->pelanggan->user->nama ?? '-' }}</span>
</div>
<div class="row">
    <span class="label">Telepon</span>
    <span class="value">{{ $pesanan->pelanggan->user->no_telepon ?? '-' }}</span>
</div>
<div class="row">
    <span class="label">Metode</span>
    <span class="value">{{ $pesanan->metode_pembayaran }}</span>
</div>

@if($pesanan->kurir)
<div class="row">
    <span class="label">Driver</span>
    <span class="value">{{ $pesanan->kurir->user->nama ?? '-' }}</span>
</div>
<div class="row">
    <span class="label">Kendaraan</span>
    <span class="value">{{ $pesanan->kurir->plat_nomor }}</span>
</div>
@endif

<div class="divider"></div>

{{-- ── Alamat Pengiriman ───────────────────────────────────────────────── --}}
<div class="bold">Alamat Pengiriman:</div>
<div style="margin: 4px 0 0 0; font-size: 11px; color: #444;">{{ $pesanan->alamat_pengiriman }}</div>

<div class="divider"></div>

{{-- ── Item Produk ─────────────────────────────────────────────────────── --}}
<div class="items-header">
    <span>Produk</span>
    <span>Subtotal</span>
</div>
@foreach($pesanan->details as $item)
<div class="item-row">
    <div class="item-name">{{ $item->produk->nama_produk ?? '-' }}</div>
    <div class="item-detail">
        <span>{{ $item->jumlah }} × Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
    </div>
</div>
@endforeach

<div class="divider"></div>

{{-- ── Ringkasan Biaya ─────────────────────────────────────────────────── --}}
<div class="row">
    <span class="label">Subtotal</span>
    <span>Rp {{ number_format($pesanan->total_belanja, 0, ',', '.') }}</span>
</div>
<div class="row">
    <span class="label">Ongkos Kirim</span>
    <span>Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
</div>
@if($pesanan->diskon_voucher > 0)
<div class="row">
    <span class="label">Diskon</span>
    <span>- Rp {{ number_format($pesanan->diskon_voucher, 0, ',', '.') }}</span>
</div>
@endif

<div class="divider-solid"></div>

<div class="total-row">
    <span>TOTAL TAGIHAN</span>
    <span>Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</span>
</div>

<div class="divider"></div>

{{-- ── Footer ──────────────────────────────────────────────────────────── --}}
<div class="footer">
    <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    <p>Terima kasih telah berbelanja di Borma!</p>
    <p>Simpan nota ini sebagai bukti pembelian.</p>
</div>

{{-- ── Tombol Print (tidak tampil saat print) ─────────────────────────── --}}
<div class="no-print" style="margin-top: 24px; text-align: center; display: flex; gap: 12px; justify-content: center;">
    <button onclick="window.print()"
        style="background:#33116C;color:white;border:none;padding:10px 24px;border-radius:8px;font-weight:700;cursor:pointer;font-size:13px;">
        🖨️ Cetak Nota
    </button>
    <button onclick="window.close()"
        style="background:#F3F4F6;color:#374151;border:none;padding:10px 24px;border-radius:8px;font-weight:700;cursor:pointer;font-size:13px;">
        ✕ Tutup
    </button>
</div>

<script>
    // Auto-trigger print dialog saat halaman terbuka
    window.addEventListener('load', function () {
        // Delay sedikit agar browser selesai render
        setTimeout(() => window.print(), 300);
    });
</script>
</body>
</html>
