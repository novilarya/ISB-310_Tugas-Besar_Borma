<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = trim((string) config('services.midtrans.server_key', config('midtrans.server_key', '')));
        Config::$isProduction = (bool) config('services.midtrans.is_production', config('midtrans.is_production', false));
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized', config('midtrans.is_sanitized', true));
        Config::$is3ds = (bool) config('services.midtrans.is_3ds', config('midtrans.is_3ds', true));
    }

    public function createTransaction(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer,qris',
            'total' => 'required|numeric|min:1',
            'customer_name' => 'required|string',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string',
            'items' => 'nullable|array',
            'shipping_address' => 'nullable|string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan login terlebih dahulu untuk melakukan pemesanan.'
            ], 401);
        }

        $user = Auth::user();
        $pelanggan = $user->pelanggan;
        if (!$pelanggan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Profil pelanggan tidak ditemukan.'
            ], 400);
        }

        $paymentMethod = $request->input('payment_method');
        $total = (int) $request->input('total');

        // Check if this is a membership activation order
        $isMembership = false;
        $paketCode = '1_bulan';
        $itemsInput = $request->input('items', []);
        if (!empty($itemsInput)) {
            foreach ($itemsInput as $item) {
                if (isset($item['id']) && str_starts_with($item['id'], 'MEMBER-')) {
                    $isMembership = true;
                    $paketCode = strtolower(str_replace('MEMBER-', '', $item['id']));
                    break;
                }
            }
        }

        $cart = [];
        if (!$isMembership) {
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Keranjang belanja kosong.'
                ], 400);
            }
        }

        // Calculate totals
        $biayaPengiriman = $isMembership ? 0 : 15000;
        $totalBelanja = $isMembership ? $total : collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $totalTagihan = $totalBelanja + $biayaPengiriman;

        DB::beginTransaction();
        try {
            // Determine payment method label
            $paymentMethodLabel = $isMembership ? 'Aktivasi Member Plus' : 'Transfer / Pembayaran Online';

            // Construct delivery address
            if ($isMembership) {
                $alamatPengiriman = 'Aktivasi Borma Plus ' . strtoupper($paketCode);
            } elseif ($request->filled('shipping_address')) {
                $alamatPengiriman = $request->input('shipping_address');
            } else {
                $alamatPengiriman = $pelanggan->alamat . ', ' . $pelanggan->kecamatan . ', ' . $pelanggan->kota_kabupaten . ', ' . $pelanggan->provinsi;
            }

            // Create Pesanan record using session's active branch
            $pesanan = \App\Models\Pesanan::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_cabang' => session('selected_cabang_id', 1),
                'id_kurir' => null,
                'id_promo' => null,
                'tanggal_pemesanan' => now(),
                'total_belanja' => $totalBelanja,
                'biaya_pengiriman' => $biayaPengiriman,
                'diskon_voucher' => 0,
                'total_tagihan' => $totalTagihan,
                'metode_pembayaran' => $paymentMethodLabel,
                'alamat_pengiriman' => $alamatPengiriman,
                'status_pesanan' => 'Menunggu',
            ]);

            // Save order items (pesanan_produks)
            if ($isMembership) {
                $paketLabel = 'Aktivasi Borma Plus - ' . ($paketCode === '2_bulan' ? '2 Bulan' : ($paketCode === '3_bulan' ? '3 Bulan' : '1 Bulan'));
                $produk = \App\Models\Produk::query()->where('nama_produk', $paketLabel)->first();
                if (!$produk) {
                    $produk = \App\Models\Produk::create([
                        'nama_produk' => $paketLabel,
                        'kategori' => 'Membership',
                        'deskripsi' => 'Aktivasi Member Premium Borma Plus - ' . $paketLabel,
                        'harga_reguler' => $total,
                        'harga_member' => $total,
                        'gambar_produk' => 'default.jpg'
                    ]);
                }

                \App\Models\PesananProduk::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $produk->id_produk,
                    'jumlah' => 1,
                    'harga_satuan' => $total,
                    'subtotal' => $total,
                    'catatan_produk' => null,
                ]);
            } else {
                foreach ($cart as $item) {
                    $produk = \App\Models\Produk::query()->where('nama_produk', $item['name'])->first();
                    if (!$produk) {
                        $produk = \App\Models\Produk::create([
                            'nama_produk' => $item['name'],
                            'kategori' => $item['category'] ?? 'Bahan Pokok',
                            'deskripsi' => $item['name'] . ' berkualitas dari Borma',
                            'harga_reguler' => $item['price'],
                            'harga_member' => $item['price'],
                            'gambar_produk' => $item['img'] ?? 'default.jpg'
                        ]);
                    }

                    \App\Models\PesananProduk::create([
                        'id_pesanan' => $pesanan->id_pesanan,
                        'id_produk' => $produk->id_produk,
                        'jumlah' => $item['quantity'],
                        'harga_satuan' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity'],
                        'catatan_produk' => null,
                    ]);
                }
            }

            // For online payment (transfer), generate Midtrans Snap Token
            $midtransOrderId = 'BORMA-' . $pesanan->id_pesanan . '-' . time();
            
            $pesanan->update([
                'midtrans_order_id' => $midtransOrderId
            ]);

            // Build Midtrans transaction payload
            $transactionDetails = [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $totalTagihan,
            ];

            $customerDetails = [
                'first_name' => $user->nama,
                'email' => $user->email ?? 'pelanggan@borma.co.id',
                'phone' => $user->no_telepon ?? '08123456789',
            ];

            // Build item details for Midtrans
            $itemDetails = [];
            if ($isMembership) {
                $itemDetails[] = [
                    'id' => 'MEMBER-AKTIVASI',
                    'price' => $total,
                    'quantity' => 1,
                    'name' => 'Aktivasi Member Plus',
                ];
            } else {
                foreach ($cart as $item) {
                    $itemDetails[] = [
                        'id' => substr(md5($item['name']), 0, 8),
                        'price' => (int) $item['price'],
                        'quantity' => (int) $item['quantity'],
                        'name' => strlen($item['name']) > 50 ? substr($item['name'], 0, 47) . '...' : $item['name'],
                    ];
                }
                $itemDetails[] = [
                    'id' => 'SHIPPING-FEE',
                    'price' => (int) $biayaPengiriman,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim Borma',
                ];
            }

            $payload = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
            ];

            Log::info('Midtrans Config used', [
                'server_key_length' => strlen(Config::$serverKey),
                'is_production' => Config::$isProduction,
            ]);

            Log::info('Midtrans Payload', $payload);

            $snapToken = Snap::getSnapToken($payload);

            $pesanan->update([
                'snap_token' => $snapToken
            ]);

            DB::commit();

            if (!$isMembership) {
                session()->forget('cart');
            }

            return response()->json([
                'status' => 'success',
                'payment_method' => 'transfer',
                'snap_token' => $snapToken,
                'order_id' => $pesanan->id_pesanan,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans Error or DB Save Error', [
                'message' => $e->getMessage(),
                'server_key_set' => !empty(Config::$serverKey),
                'server_key_length' => strlen(Config::$serverKey),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Midtrans payment notification (webhook).
     */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $paymentType = $notification->payment_type;
            $fraudStatus = $notification->fraud_status;

            // Log the notification for debugging
            Log::info('Midtrans Notification', [
                'order_id' => $orderId,
                'transaction_status' =>  $transactionStatus,
                'payment_type' => $paymentType,
                'fraud_status' => $fraudStatus,
            ]);

            $pesanan = \App\Models\Pesanan::query()->where('midtrans_order_id', $orderId)->first();

            if ($pesanan) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $pesanan->update(['status_pesanan' => 'Menunggu']);
                    Log::info("Payment successful for order: {$orderId}, status updated to Menunggu");

                    self::processPaymentAndStock($pesanan);

                    // Activate membership status if this order is for membership activation
                    if ($pesanan->metode_pembayaran === 'Aktivasi Member Plus' || str_contains($pesanan->alamat_pengiriman, 'Aktivasi Borma Plus')) {
                        $pelanggan = $pesanan->pelanggan;
                        if ($pelanggan) {
                            $months = 1;
                            if (str_contains(strtoupper($pesanan->alamat_pengiriman), '2_BULAN')) {
                                $months = 2;
                            } elseif (str_contains(strtoupper($pesanan->alamat_pengiriman), '3_BULAN')) {
                                $months = 3;
                            }
                            $pelanggan->update([
                                'status_member_plus' => 1,
                                'tanggal_berakhir_member_plus' => now()->addMonths($months)->toDateString()
                            ]);
                            Log::info("Pelanggan {$pelanggan->id_pelanggan} status_member_plus updated to 1 and expiration set to {$months} months via Webhook");
                        }
                    }
                } elseif ($transactionStatus == 'pending') {
                    $pesanan->update(['status_pesanan' => 'Menunggu']);
                    Log::info("Payment pending for order: {$orderId}");
                } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                    $pesanan->update(['status_pesanan' => 'gagal']);
                    Log::info("Payment failed/cancelled for order: {$orderId}");
                }
            } else {
                Log::warning("Order with midtrans_order_id {$orderId} not found in DB.");
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Handle payment finish redirect from Midtrans Snap.
     */
    public function paymentFinish(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if ($orderId) {
            $pesanan = \App\Models\Pesanan::query()->where('midtrans_order_id', $orderId)
                ->orWhere('id_pesanan', $orderId)
                ->first();
                
            if ($pesanan) {
                $pesanan->update(['status_pesanan' => 'Menunggu']);
                Log::info("Payment finish landed: Order {$orderId} status set to Menunggu locally.");

                self::processPaymentAndStock($pesanan);
                
                // If membership, activate it immediately
                if ($pesanan->metode_pembayaran === 'Aktivasi Member Plus' || str_contains($pesanan->alamat_pengiriman, 'Aktivasi Borma Plus')) {
                    $pelanggan = $pesanan->pelanggan;
                    if ($pelanggan) {
                        $months = 1;
                        if (str_contains(strtoupper($pesanan->alamat_pengiriman), '2_BULAN')) {
                            $months = 2;
                        } elseif (str_contains(strtoupper($pesanan->alamat_pengiriman), '3_BULAN')) {
                            $months = 3;
                        }
                        $pelanggan->update([
                            'status_member_plus' => 1,
                            'tanggal_berakhir_member_plus' => now()->addMonths($months)->toDateString()
                        ]);
                        Log::info("Pelanggan {$pelanggan->id_pelanggan} membership set to 1 (plus) and expiration set to {$months} months locally.");
                    }
                    return redirect()->route('pelanggan.profil')->with('success', 'Pembayaran berhasil! Status Anda telah berubah menjadi pelanggan Borma Plus.');
                }
            }
        }

        return redirect()->route('pelanggan.dashboard')->with('success', 'Pembayaran berhasil! Terima kasih telah berbelanja di Borma.');
    }

    /**
     * Helper to process payment and update stock and sales count idempotently.
     */
    public static function processPaymentAndStock($pesanan)
    {
        // Skip for membership activation
        if ($pesanan->metode_pembayaran === 'Aktivasi Member Plus' || str_contains($pesanan->alamat_pengiriman, 'Aktivasi Borma Plus')) {
            return;
        }

        // Check if already processed to prevent double stock reduction
        $alreadyProcessed = \App\Models\PengirimanTracking::where('id_pesanan', $pesanan->id_pesanan)
            ->where('keterangan', 'like', '%stok dikurangi%')
            ->exists();

        if ($alreadyProcessed) {
            return;
        }

        // Reduce stock and increment sold count
        foreach ($pesanan->details as $detail) {
            \App\Models\ProdukCabang::where('id_produk', $detail->id_produk)
                ->where('id_cabang', $pesanan->id_cabang)
                ->decrement('jumlah_stok', $detail->jumlah);

            \App\Models\ProdukCabang::where('id_produk', $detail->id_produk)
                ->where('id_cabang', $pesanan->id_cabang)
                ->increment('jumlah_terjual', $detail->jumlah);
        }

        // Record tracking
        \App\Models\PengirimanTracking::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => $pesanan->status_pesanan,
            'keterangan' => 'Pembayaran berhasil, stok dikurangi dan penjualan terhitung'
        ]);
    }
}