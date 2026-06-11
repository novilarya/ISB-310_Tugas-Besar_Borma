<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    /**
     * Get all products data (used internally)
     */
    private function getAllProducts()
    {
        $catKeys = [
            'Sembako & Bahan Pokok' => 'sembako',
            'Sayur & Buah' => 'sayur-buah',
            'Daging & Ikan' => 'daging-ikan',
            'Susu & Olahan' => 'susu-olahan',
            'Minuman' => 'minuman',
            'Snack & Camilan' => 'snack-camilan',
            'Kebutuhan Rumah' => 'kebutuhan-rumah',
            'Perawatan Diri' => 'perawatan-diri',
        ];

        return \App\Models\Produk::all()->map(function($p) use ($catKeys) {
            $catKey = $catKeys[$p->kategori] ?? 'sembako';
            $sale = $p->harga_member_plus < $p->harga_member ? $p->harga_member_plus : 0;
            return [
                'name' => $p->nama_produk,
                'cat' => $catKey,
                'price' => $p->harga_member,
                'sale' => $sale,
                'img' => $p->gambar_produk ?: '',
            ];
        })->toArray();
    }

    private function getCategoryLabels()
    {
        return [
            'sembako' => 'Sembako & Bahan Pokok',
            'sayur-buah' => 'Sayur & Buah',
            'daging-ikan' => 'Daging & Ikan',
            'susu-olahan' => 'Susu & Olahan',
            'minuman' => 'Minuman',
            'snack-camilan' => 'Snack & Camilan',
            'kebutuhan-rumah' => 'Kebutuhan Rumah',
            'perawatan-diri' => 'Perawatan Diri',
        ];
    }

    /**
     * Refresh prices inside the cart based on user membership type (regular vs member plus)
     */
    private function refreshCartPrices(&$cart)
    {
        $user = auth()->user();
        $isMemberPlus = $user && $user->pelanggan && $user->pelanggan->status_member_plus;

        $products = \App\Models\Produk::all()->keyBy('nama_produk');

        $updated = false;
        foreach ($cart as $key => $item) {
            $productName = $item['name'] ?? null;
            if ($productName && isset($products[$productName])) {
                $product = $products[$productName];
                $correctPrice = $isMemberPlus ? $product->harga_member_plus : $product->harga_member;
                
                if (!isset($cart[$key]['price']) || $cart[$key]['price'] != $correctPrice) {
                    $cart[$key]['price'] = $correctPrice;
                    $updated = true;
                }
                
                if (!isset($cart[$key]['original_price']) || $cart[$key]['original_price'] != $product->harga_member) {
                    $cart[$key]['original_price'] = $product->harga_member;
                    $updated = true;
                }

                if (!isset($cart[$key]['img']) || $cart[$key]['img'] != ($product->gambar_produk ?: '')) {
                    $cart[$key]['img'] = $product->gambar_produk ?: '';
                    $updated = true;
                }
            }
        }

        if ($updated) {
            session()->put('cart', $cart);
        }
    }

    /**
     * Add product to cart (AJAX)
     */
    public function add(Request $request)
    {
        $productName = $request->input('product_name');
        $allProducts = $this->getAllProducts();
        $product = collect($allProducts)->firstWhere('name', $productName);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
        }

        $cart = session()->get('cart', []);
        $key = md5($productName);

        $qty = intval($request->input('quantity', 1));
        if ($qty < 1) $qty = 1;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty;
        } else {
            $user = auth()->user();
            $isMemberPlus = $user && $user->pelanggan && $user->pelanggan->status_member_plus;
            $cart[$key] = [
                'name' => $product['name'],
                'category' => $product['cat'],
                'price' => ($isMemberPlus && $product['sale'] > 0) ? $product['sale'] : $product['price'],
                'original_price' => $product['price'],
                'img' => $product['img'],
                'quantity' => $qty,
            ];
        }

        $this->refreshCartPrices($cart);
        session()->put('cart', $cart);

        $totalItems = collect($cart)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => $product['name'] . ' ditambahkan ke keranjang!',
            'cart_count' => $totalItems,
        ]);
    }

    /**
     * Update quantity (AJAX)
     */
    public function update(Request $request)
    {
        $key = $request->input('key');
        $action = $request->input('action'); // 'increment' or 'decrement'

        $cart = session()->get('cart', []);

        if (!isset($cart[$key])) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.'], 404);
        }

        if ($action === 'increment') {
            $cart[$key]['quantity'] += 1;
        } elseif ($action === 'decrement') {
            $cart[$key]['quantity'] -= 1;
            if ($cart[$key]['quantity'] <= 0) {
                unset($cart[$key]);
            }
        }

        $this->refreshCartPrices($cart);
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'cart_count' => collect($cart)->sum('quantity'),
        ]);
    }

    /**
     * Remove item from cart (AJAX)
     */
    public function remove(Request $request)
    {
        $key = $request->input('key');
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
        }

        $this->refreshCartPrices($cart);
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'cart_count' => collect($cart)->sum('quantity'),
        ]);
    }

    /**
     * Show cart page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $this->refreshCartPrices($cart);
        $categories = $this->getCategoryLabels();
        return view('pelanggan.keranjang', compact('cart', 'categories'));
    }

    /**
     * Get cart count (AJAX)
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $totalItems = collect($cart)->sum('quantity');
        return response()->json(['cart_count' => $totalItems]);
    }

    /**
     * Show checkout page with real cart data
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $this->refreshCartPrices($cart);
        if (empty($cart)) {
            return redirect()->route('pelanggan.keranjang')->with('error', 'Keranjang masih kosong.');
        }

        // Check if address/profile is incomplete (Scenario 1 & 2)
        $user = auth()->user();
        $pelanggan = $user->pelanggan;

        $isIncomplete = !$user->nama || 
                        !$user->no_telepon || $user->no_telepon === '-' ||
                        !$pelanggan || 
                        !$pelanggan->provinsi || $pelanggan->provinsi === '-' ||
                        !$pelanggan->kota_kabupaten || $pelanggan->kota_kabupaten === '-' ||
                        !$pelanggan->kecamatan || $pelanggan->kecamatan === '-' ||
                        !$pelanggan->alamat || $pelanggan->alamat === '-';

        if ($isIncomplete) {
            return redirect()->route('pelanggan.profil')->with('error', 'Lengkapi profil, nomor telepon, dan alamat pengiriman Anda terlebih dahulu untuk melanjutkan pembayaran.');
        }

        $categories = $this->getCategoryLabels();
        $totalItems = collect($cart)->sum('quantity');
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Add id_produk to cart items for promo matching
        $productNames = array_column($cart, 'name');
        $dbProducts = \App\Models\Produk::whereIn('nama_produk', $productNames)->get()->keyBy('nama_produk');

        foreach ($cart as $key => &$item) {
            if (isset($dbProducts[$item['name']])) {
                $item['id_produk'] = $dbProducts[$item['name']]->id_produk;
            } else {
                $item['id_produk'] = null;
            }
        }
        unset($item);

        // Fetch active promos/vouchers
        $vouchers = \App\Models\Promo::query()
            ->where('tanggal_mulai', '<=', now()->toDateString())
            ->where('tanggal_berakhir', '>=', now()->toDateString())
            ->get();

        // Get additional addresses from database
        $alamatTambahan = $pelanggan ? $pelanggan->alamatTambahan()->orderBy('created_at', 'desc')->first() : null;

        // Fetch selected cabang
        $selectedCabangId = session('selected_cabang_id');
        $selectedCabang = null;
        if ($selectedCabangId) {
            $selectedCabang = \App\Models\Cabang::find($selectedCabangId);
        }

        // Calculate dynamic shipping cost based on selected branch distance
        $distance = session('selected_cabang_distance');
        $shippingCost = 0;
        if ($selectedCabang) {
            $distance = $distance ?? 0;
            $shippingCost = 15000;
            if ($distance > 5) {
                $additionalDistance = ceil($distance - 5);
                $shippingCost = 15000 + ($additionalDistance * 1000);
            }
        }

        return view('pelanggan.checkout', compact('cart', 'categories', 'totalItems', 'subtotal', 'alamatTambahan', 'vouchers', 'shippingCost', 'distance', 'selectedCabang'));
    }

    /**
     * Clear the cart (after successful payment)
     */
    public function clear()
    {
        session()->forget('cart');
        return response()->json(['success' => true]);
    }
}
