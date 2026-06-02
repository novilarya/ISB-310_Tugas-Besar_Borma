<?php
require 'vendor/autoload.php';

use Midtrans\Config;
use Midtrans\Snap;

Config::$serverKey = 'SB-Mid-server-U8XXqrywt2HXkNH0jGlsPgyv';
Config::$isProduction = false;
Config::$isSanitized = true;
Config::$is3ds = true;

$params = [
    'transaction_details' => [
        'order_id' => 'TEST-' . time(),
        'gross_amount' => 10000,
    ],
    'customer_details' => [
        'first_name' => 'Test',
        'email' => 'test@example.com',
        'phone' => '08123456789',
    ]
];

try {
    echo "Creating transaction...\n";
    $token = Snap::getSnapToken($params);
    echo "Token created successfully: " . $token . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
