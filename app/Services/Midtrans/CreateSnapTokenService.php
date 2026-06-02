<?php

namespace App\Services\Midtrans;

use Midtrans\Config;
use Midtrans\Snap;

class CreateSnapTokenService
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;

        // Set Midtrans config using Laravel helper
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->midtrans_order_id ?? ('BORMA-' . $this->order->id_pesanan . '-' . time()),
                'gross_amount' => (int) $this->order->total_tagihan,
            ],
            'customer_details' => [
                'first_name' => $this->order->pelanggan->user->nama ?? 'Pelanggan',
                'email' => $this->order->pelanggan->user->email ?? 'pelanggan@borma.co.id',
                'phone' => $this->order->pelanggan->user->no_telepon ?? '',
            ]
        ];

        return Snap::getSnapToken($params);
    }
}