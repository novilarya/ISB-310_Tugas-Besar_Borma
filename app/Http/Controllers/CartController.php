<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get all products data (used internally)
     */
    private function getAllProducts()
    {
        return [
            ['name'=>'Beras Pandan Wangi 5kg','cat'=>'sembako','price'=>78000,'sale'=>72000,'img'=>'beras-pandan-wangi.jpg'],
            ['name'=>'Minyak Goreng Bimoli 2L','cat'=>'sembako','price'=>45000,'sale'=>32500,'img'=>'minyak-goreng-bimoli.jpg'],
            ['name'=>'Gula Pasir Lokal 1kg','cat'=>'sembako','price'=>18000,'sale'=>0,'img'=>'gula-pasir.jpg'],
            ['name'=>'Tepung Terigu Segitiga Biru 1kg','cat'=>'sembako','price'=>14500,'sale'=>0,'img'=>'tepung-terigu.jpg'],
            ['name'=>'Mie Instan Goreng (5pcs)','cat'=>'sembako','price'=>15000,'sale'=>12500,'img'=>'mie-instan.jpg'],
            ['name'=>'Kecap Manis ABC 600ml','cat'=>'sembako','price'=>22000,'sale'=>0,'img'=>'kecap-manis.jpg'],
            ['name'=>'Telur Ayam 1kg','cat'=>'sembako','price'=>28000,'sale'=>26000,'img'=>'telur-ayam.jpg'],
            ['name'=>'Garam Dapur Cap Kapal 500g','cat'=>'sembako','price'=>5000,'sale'=>0,'img'=>'garam-dapur.jpg'],
            ['name'=>'Santan Kara 200ml','cat'=>'sembako','price'=>8500,'sale'=>7000,'img'=>'santan.jpg'],
            ['name'=>'Saus Tomat ABC 335ml','cat'=>'sembako','price'=>12000,'sale'=>0,'img'=>'saus-tomat.jpg'],
            ['name'=>'Apel Fuji Premium 1kg','cat'=>'sayur-buah','price'=>45000,'sale'=>36000,'img'=>'apel-fuji.jpg'],
            ['name'=>'Wortel Lokal Organik 500g','cat'=>'sayur-buah','price'=>12000,'sale'=>0,'img'=>'wortel.jpg'],
            ['name'=>'Pisang Cavendish (Sisir)','cat'=>'sayur-buah','price'=>25000,'sale'=>0,'img'=>'pisang.jpg'],
            ['name'=>'Brokoli Segar (Pcs)','cat'=>'sayur-buah','price'=>18500,'sale'=>0,'img'=>'brokoli.jpg'],
            ['name'=>'Bayam Petik (Ikat)','cat'=>'sayur-buah','price'=>4500,'sale'=>0,'img'=>'bayam.jpg'],
            ['name'=>'Strawberry Korea (Box)','cat'=>'sayur-buah','price'=>85000,'sale'=>75000,'img'=>'strawberry.jpg'],
            ['name'=>'Tomat Merah 500g','cat'=>'sayur-buah','price'=>10000,'sale'=>0,'img'=>'tomat.jpg'],
            ['name'=>'Jeruk Sunkist 1kg','cat'=>'sayur-buah','price'=>35000,'sale'=>30000,'img'=>'jeruk.jpg'],
            ['name'=>'Kentang Dieng 1kg','cat'=>'sayur-buah','price'=>16000,'sale'=>0,'img'=>'kentang.jpg'],
            ['name'=>'Kangkung Segar (Ikat)','cat'=>'sayur-buah','price'=>3500,'sale'=>0,'img'=>'kangkung.jpg'],
            ['name'=>'Mangga Harum Manis 1kg','cat'=>'sayur-buah','price'=>28000,'sale'=>24000,'img'=>'mangga.jpg'],
            ['name'=>'Daging Sapi Has Dalam 500g','cat'=>'daging-ikan','price'=>75000,'sale'=>0,'img'=>'daging-sapi.jpg'],
            ['name'=>'Ayam Potong Broiler 1kg','cat'=>'daging-ikan','price'=>38000,'sale'=>34000,'img'=>'ayam-potong.jpg'],
            ['name'=>'Ikan Salmon Fillet 200g','cat'=>'daging-ikan','price'=>65000,'sale'=>0,'img'=>'salmon.jpg'],
            ['name'=>'Udang Vaname 500g','cat'=>'daging-ikan','price'=>55000,'sale'=>48000,'img'=>'udang.jpg'],
            ['name'=>'Bakso Sapi Kemasan 500g','cat'=>'daging-ikan','price'=>32000,'sale'=>0,'img'=>'bakso.jpg'],
            ['name'=>'Ikan Tuna Steak 300g','cat'=>'daging-ikan','price'=>42000,'sale'=>0,'img'=>'tuna.jpg'],
            ['name'=>'Sosis Ayam So Nice 375g','cat'=>'daging-ikan','price'=>25000,'sale'=>22000,'img'=>'sosis.jpg'],
            ['name'=>'Nugget Fiesta 500g','cat'=>'daging-ikan','price'=>38000,'sale'=>0,'img'=>'nugget.jpg'],
            ['name'=>'Cumi-Cumi Segar 500g','cat'=>'daging-ikan','price'=>45000,'sale'=>0,'img'=>'cumi.jpg'],
            ['name'=>'Daging Giling Sapi 500g','cat'=>'daging-ikan','price'=>60000,'sale'=>55000,'img'=>'daging-giling.jpg'],
            ['name'=>'Susu Ultra Milk Full Cream 1L','cat'=>'susu-olahan','price'=>21000,'sale'=>18500,'img'=>'susu-uht.jpg'],
            ['name'=>'Keju Kraft Cheddar 165g','cat'=>'susu-olahan','price'=>18000,'sale'=>0,'img'=>'keju-cheddar.jpg'],
            ['name'=>'Yogurt Cimory 250ml','cat'=>'susu-olahan','price'=>12000,'sale'=>10000,'img'=>'yogurt.jpg'],
            ['name'=>'Mentega Blue Band 200g','cat'=>'susu-olahan','price'=>15000,'sale'=>0,'img'=>'mentega.jpg'],
            ['name'=>'Susu Kental Manis Frisian 370g','cat'=>'susu-olahan','price'=>14000,'sale'=>0,'img'=>'susu-kental.jpg'],
            ['name'=>'Susu Indomilk Coklat 1L','cat'=>'susu-olahan','price'=>19000,'sale'=>0,'img'=>'susu-coklat.jpg'],
            ['name'=>'Keju Mozzarella 200g','cat'=>'susu-olahan','price'=>35000,'sale'=>30000,'img'=>'keju-mozzarella.jpg'],
            ['name'=>'Cream Cheese Anchor 250g','cat'=>'susu-olahan','price'=>42000,'sale'=>0,'img'=>'cream-cheese.jpg'],
            ['name'=>'Susu Bear Brand Gold 140ml','cat'=>'susu-olahan','price'=>12000,'sale'=>10500,'img'=>'bear-brand.jpg'],
            ['name'=>'Butter Wijsman 200g','cat'=>'susu-olahan','price'=>55000,'sale'=>0,'img'=>'butter.jpg'],
            ['name'=>'Teh Botol Sosro 450ml','cat'=>'minuman','price'=>5000,'sale'=>0,'img'=>'teh-botol.jpg'],
            ['name'=>'Coca Cola 1.5L','cat'=>'minuman','price'=>16000,'sale'=>14000,'img'=>'coca-cola.jpg'],
            ['name'=>'Aqua 600ml (6pcs)','cat'=>'minuman','price'=>12000,'sale'=>0,'img'=>'aqua.jpg'],
            ['name'=>'Kopi Good Day Cappuccino 10s','cat'=>'minuman','price'=>18000,'sale'=>15000,'img'=>'kopi.jpg'],
            ['name'=>'Yakult 5x65ml','cat'=>'minuman','price'=>10000,'sale'=>0,'img'=>'yakult.jpg'],
            ['name'=>'Pocari Sweat 500ml','cat'=>'minuman','price'=>8000,'sale'=>0,'img'=>'pocari.jpg'],
            ['name'=>'Sirup Marjan Cocopandan 460ml','cat'=>'minuman','price'=>22000,'sale'=>19000,'img'=>'sirup.jpg'],
            ['name'=>'Le Minerale 600ml (6pcs)','cat'=>'minuman','price'=>11000,'sale'=>0,'img'=>'le-minerale.jpg'],
            ['name'=>'Fanta Strawberry 1.5L','cat'=>'minuman','price'=>14000,'sale'=>0,'img'=>'fanta.jpg'],
            ['name'=>'Nutrisari Jeruk 10s','cat'=>'minuman','price'=>12000,'sale'=>10000,'img'=>'nutrisari.jpg'],
            ['name'=>'Chitato Sapi Panggang 68g','cat'=>'snack-camilan','price'=>10000,'sale'=>0,'img'=>'chitato.jpg'],
            ['name'=>'Oreo Vanilla 133g','cat'=>'snack-camilan','price'=>12000,'sale'=>10000,'img'=>'oreo.jpg'],
            ['name'=>'Pringles Original 110g','cat'=>'snack-camilan','price'=>28000,'sale'=>0,'img'=>'pringles.jpg'],
            ['name'=>'Pocky Strawberry 45g','cat'=>'snack-camilan','price'=>9000,'sale'=>0,'img'=>'pocky.jpg'],
            ['name'=>'Coklat Silverqueen 65g','cat'=>'snack-camilan','price'=>16000,'sale'=>14000,'img'=>'silverqueen.jpg'],
            ['name'=>'Tango Wafer Coklat 176g','cat'=>'snack-camilan','price'=>14000,'sale'=>0,'img'=>'tango-wafer.jpg'],
            ['name'=>'Lays Classic 68g','cat'=>'snack-camilan','price'=>10000,'sale'=>0,'img'=>'lays.jpg'],
            ['name'=>'Biskuit Roma Kelapa 300g','cat'=>'snack-camilan','price'=>8000,'sale'=>6500,'img'=>'biskuit-roma.jpg'],
            ['name'=>'Kacang Garuda 100g','cat'=>'snack-camilan','price'=>12000,'sale'=>0,'img'=>'kacang-garuda.jpg'],
            ['name'=>'Nabati Richeese 150g','cat'=>'snack-camilan','price'=>11000,'sale'=>9500,'img'=>'nabati.jpg'],
            ['name'=>'Deterjen Rinso Anti Noda 800g','cat'=>'kebutuhan-rumah','price'=>22000,'sale'=>0,'img'=>'rinso.jpg'],
            ['name'=>'Sabun Cuci Piring Sunlight 800ml','cat'=>'kebutuhan-rumah','price'=>16000,'sale'=>14000,'img'=>'sunlight.jpg'],
            ['name'=>'Pewangi Molto 900ml','cat'=>'kebutuhan-rumah','price'=>24000,'sale'=>0,'img'=>'molto.jpg'],
            ['name'=>'Pembersih Lantai Super Pell 800ml','cat'=>'kebutuhan-rumah','price'=>14000,'sale'=>0,'img'=>'super-pell.jpg'],
            ['name'=>'Tissue Paseo 250 Sheet','cat'=>'kebutuhan-rumah','price'=>18000,'sale'=>15000,'img'=>'tissue.jpg'],
            ['name'=>'Sapu Ijuk Premium','cat'=>'kebutuhan-rumah','price'=>25000,'sale'=>0,'img'=>'sapu.jpg'],
            ['name'=>'Kain Lap Microfiber 3pcs','cat'=>'kebutuhan-rumah','price'=>20000,'sale'=>0,'img'=>'lap-microfiber.jpg'],
            ['name'=>'Baygon Aerosol 600ml','cat'=>'kebutuhan-rumah','price'=>35000,'sale'=>30000,'img'=>'baygon.jpg'],
            ['name'=>'Ember Plastik 20L','cat'=>'kebutuhan-rumah','price'=>28000,'sale'=>0,'img'=>'ember.jpg'],
            ['name'=>'Trash Bag Roll 45x50 20pcs','cat'=>'kebutuhan-rumah','price'=>12000,'sale'=>0,'img'=>'trash-bag.jpg'],
            ['name'=>'Shampo Pantene 400ml','cat'=>'perawatan-diri','price'=>42000,'sale'=>38000,'img'=>'shampo.jpg'],
            ['name'=>'Sabun Lifebuoy 100g (4pcs)','cat'=>'perawatan-diri','price'=>18000,'sale'=>0,'img'=>'sabun-lifebuoy.jpg'],
            ['name'=>'Pasta Gigi Pepsodent 190g','cat'=>'perawatan-diri','price'=>14000,'sale'=>12000,'img'=>'pasta-gigi.jpg'],
            ['name'=>'Deodoran Rexona 50ml','cat'=>'perawatan-diri','price'=>22000,'sale'=>0,'img'=>'deodoran.jpg'],
            ['name'=>'Sunscreen Nivea SPF50 100ml','cat'=>'perawatan-diri','price'=>48000,'sale'=>0,'img'=>'sunscreen.jpg'],
            ['name'=>'Hand Body Vaseline 200ml','cat'=>'perawatan-diri','price'=>25000,'sale'=>22000,'img'=>'hand-body.jpg'],
            ['name'=>'Sikat Gigi Oral-B 3pcs','cat'=>'perawatan-diri','price'=>28000,'sale'=>0,'img'=>'sikat-gigi.jpg'],
            ['name'=>'Kapas Wajah Selection 50g','cat'=>'perawatan-diri','price'=>8000,'sale'=>0,'img'=>'kapas.jpg'],
            ['name'=>'Conditioner Dove 320ml','cat'=>'perawatan-diri','price'=>35000,'sale'=>30000,'img'=>'conditioner.jpg'],
            ['name'=>'Sabun Cair Dettol 300ml','cat'=>'perawatan-diri','price'=>32000,'sale'=>0,'img'=>'sabun-cair.jpg'],
        ];
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

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += 1;
        } else {
            $cart[$key] = [
                'name' => $product['name'],
                'category' => $product['cat'],
                'price' => $product['sale'] > 0 ? $product['sale'] : $product['price'],
                'original_price' => $product['price'],
                'img' => $product['img'],
                'quantity' => 1,
            ];
        }

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
        if (empty($cart)) {
            return redirect()->route('pelanggan.keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $categories = $this->getCategoryLabels();
        $totalItems = collect($cart)->sum('quantity');
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('pelanggan.checkout', compact('cart', 'categories', 'totalItems', 'subtotal'));
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
