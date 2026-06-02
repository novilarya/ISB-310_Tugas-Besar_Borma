<?php

namespace App\Mail;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function build()
    {
        $orderId = '#BRM-9' . str_pad($this->pesanan->id_pesanan, 3, '0', STR_PAD_LEFT);
        return $this->subject('Nota Pembelian Borma Toserba ' . $orderId)
                    ->view('emails.invoice');
    }
}
