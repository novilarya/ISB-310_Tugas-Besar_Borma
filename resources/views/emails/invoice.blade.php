<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembelian Borma Toserba</title>
</head>
<body style="margin: 0; padding: 0; background-color: #F3F4F6; font-family: 'Plus Jakarta Sans', 'Segoe UI', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F3F4F6; padding: 32px 0;">
        <tr>
            <td align="center">
                <!-- Outer Card Wrapper -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #33116C 0%, #1c093d 100%); padding: 32px 24px; color: #ffffff;">
                            @if($pesanan->metode_pembayaran === 'Aktivasi Member Plus' || str_contains($pesanan->alamat_pengiriman, 'Aktivasi Borma Plus'))
                                <h1 style="margin: 0; font-size: 28px; font-weight: 800; letter-spacing: 2px; color: #FED50B;">BORMA PLUS</h1>
                                <p style="margin: 6px 0 0 0; font-size: 13px; color: #ffffff; opacity: 0.85; font-weight: 600; letter-spacing: 0.5px;">Layanan Membership Digital Borma</p>
                            @else
                                <h1 style="margin: 0; font-size: 28px; font-weight: 800; letter-spacing: 2px; color: #FED50B;">BORMA</h1>
                                <p style="margin: 6px 0 0 0; font-size: 13px; color: #ffffff; opacity: 0.85; font-weight: 600; letter-spacing: 0.5px;">Toserba Borma — {{ $pesanan->cabang->nama_cabang ?? 'Antapani' }}</p>
                                <p style="margin: 4px 0 0 0; font-size: 11px; color: #ffffff; opacity: 0.7; font-weight: 500;">{{ $pesanan->cabang->alamat_cabang ?? 'Jl. Terusan Jakarta No. 53, Bandung' }}</p>
                            @endif
                        </td>
                    </tr>

                    <!-- Status Notification Bar -->
                    <tr>
                        <td style="padding: 24px 24px 8px 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: rgba(51, 17, 108, 0.04); border-radius: 12px; padding: 18px;">
                                <tr>
                                    <td>
                                        <h3 style="margin: 0 0 6px 0; color: #33116C; font-size: 16px; font-weight: 800;">Halo, {{ $pesanan->pelanggan->user->nama ?? 'Pelanggan Setia Borma' }}!</h3>
                                        <p style="margin: 0; color: #4B5563; font-size: 13px; line-height: 1.6; font-weight: 500;">
                                            @if($pesanan->metode_pembayaran === 'Aktivasi Member Plus' || str_contains($pesanan->alamat_pengiriman, 'Aktivasi Borma Plus'))
                                                Aktivasi membership Borma Plus Anda telah berhasil dan aktif. Terima kasih telah berlangganan layanan premium kami!
                                            @else
                                                Pesanan Anda telah kami konfirmasi! Tim kami di cabang <strong>{{ $pesanan->cabang->nama_cabang ?? 'Borma Toserba' }}</strong> sedang menyiapkan produk-produk pilihan Anda untuk segera dikirimkan.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Transaction details -->
                    <tr>
                        <td style="padding: 16px 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="50%">
                                        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; display: block;">Nomor Pesanan</span>
                                        <span style="font-size: 18px; font-weight: 800; color: #33116C; display: block; margin-top: 4px;">#BRM-9{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td width="50%" align="right">
                                        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; display: block;">Metode Pembayaran</span>
                                        <span style="font-size: 14px; font-weight: 800; color: #111827; display: block; margin-top: 6px;">{{ $pesanan->metode_pembayaran }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 16px;">
                                        <div style="border-top: 1px dashed #E5E7EB; margin-bottom: 16px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="font-size: 11px; font-weight: 700; color: #6B7280; display: block;">Tanggal Pembelian:</span>
                                        <span style="font-size: 13px; font-weight: 700; color: #111827; display: block; margin-top: 2px;">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d F Y, H:i') }}</span>
                                    </td>
                                    <td align="right">
                                        <span style="font-size: 11px; font-weight: 700; color: #6B7280; display: block;">Nomor Telepon:</span>
                                        <span style="font-size: 13px; font-weight: 700; color: #111827; display: block; margin-top: 2px;">{{ $pesanan->pelanggan->user->no_telepon ?? '-' }}</span>
                                    </td>
                                </tr>
                                @if(!($pesanan->metode_pembayaran === 'Aktivasi Member Plus' || str_contains($pesanan->alamat_pengiriman, 'Aktivasi Borma Plus')))
                                <tr>
                                    <td colspan="2" style="padding-top: 12px;">
                                        <span style="font-size: 11px; font-weight: 700; color: #6B7280; display: block;">Alamat Pengiriman:</span>
                                        <span style="font-size: 13px; font-weight: 700; color: #374151; display: block; margin-top: 4px; line-height: 1.5; background-color: #F9FAFB; padding: 10px; border-radius: 8px; border: 1px solid #F3F4F6;">{{ $pesanan->alamat_pengiriman }}</span>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- CTA Action Button to Print/Save PDF -->
                    @if(!($pesanan->metode_pembayaran === 'Aktivasi Member Plus' || str_contains($pesanan->alamat_pengiriman, 'Aktivasi Borma Plus')))
                    <tr>
                        <td align="center" style="padding: 0 24px 20px 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('public.pesanan.nota', $pesanan->id_pesanan) }}" target="_blank" style="background-color: #33116C; color: #ffffff; padding: 12px 32px; border-radius: 10px; font-weight: 800; font-size: 13px; text-decoration: none; display: inline-block; box-shadow: 0 4px 12px rgba(51, 17, 108, 0.15); letter-spacing: 0.5px; border: 2px solid #33116C; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">
                                            Cetak & Unduh PDF Nota Resmi
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif

                    <!-- Member Card (Only for Borma Plus Membership) -->
                    @if($pesanan->metode_pembayaran === 'Aktivasi Member Plus' || str_contains($pesanan->alamat_pengiriman, 'Aktivasi Borma Plus'))
                    <tr>
                        <td style="padding: 12px 24px 24px 24px;" align="center">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background: linear-gradient(135deg, #1e1b4b 0%, #31105e 50%, #4c1d95 100%); border-radius: 20px; padding: 24px; color: #ffffff; box-shadow: 0 8px 30px rgba(49, 16, 94, 0.25);">
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td>
                                                    <span style="font-size: 14px; font-weight: 800; color: #FED50B; letter-spacing: 1px; text-transform: uppercase; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">BORMA PLUS MEMBER</span>
                                                    <span style="display: block; font-size: 10px; color: #a5b4fc; font-weight: 600; margin-top: 2px; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">DIGITAL PREMIUM CARD</span>
                                                </td>
                                                <td align="right">
                                                    <div style="background: rgba(254, 213, 11, 0.1); border: 1.5px solid #FED50B; border-radius: 8px; padding: 4px 10px; font-size: 10px; font-weight: 800; color: #FED50B; text-transform: uppercase; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">ACTIVE</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 28px; padding-bottom: 24px;">
                                                    <span style="font-size: 11px; color: #a5b4fc; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">Nomor Kartu Member</span>
                                                    @php
                                                        $rawId = str_pad($pesanan->pelanggan->id_pengguna * 7919 + 100000000000, 12, '0', STR_PAD_LEFT);
                                                        $formattedId = substr($rawId, 0, 4) . ' ' . substr($rawId, 4, 4) . ' ' . substr($rawId, 8, 4);
                                                    @endphp
                                                    <span style="font-family: 'Courier New', Courier, monospace; font-size: 20px; font-weight: 800; color: #ffffff; letter-spacing: 2px;">{{ $formattedId }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span style="font-size: 9px; color: #a5b4fc; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 2px; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">Nama Pemegang</span>
                                                    <span style="font-size: 14px; font-weight: 800; color: #ffffff; text-transform: uppercase; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">{{ $pesanan->pelanggan->user->nama ?? 'Member Borma Plus' }}</span>
                                                </td>
                                                <td align="right">
                                                    <span style="font-size: 9px; color: #a5b4fc; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 2px; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">Berlaku Hingga</span>
                                                    <span style="font-size: 14px; font-weight: 800; color: #FED50B; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;">{{ $pesanan->pelanggan->tanggal_berakhir_member_plus ? \Carbon\Carbon::parse($pesanan->pelanggan->tanggal_berakhir_member_plus)->format('d/m/Y') : '--/--/----' }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif

                    <!-- Items Table -->
                    <tr>
                        <td style="padding: 12px 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #E5E7EB; border-radius: 12px; overflow: hidden;">
                                <tr style="background-color: #33116C;">
                                    <th align="left" style="padding: 12px 16px; font-size: 12px; font-weight: 800; color: #ffffff; text-transform: uppercase;">Produk</th>
                                    <th align="center" style="padding: 12px 16px; font-size: 12px; font-weight: 800; color: #ffffff; text-transform: uppercase;" width="10%">Qty</th>
                                    <th align="right" style="padding: 12px 16px; font-size: 12px; font-weight: 800; color: #ffffff; text-transform: uppercase;" width="30%">Subtotal</th>
                                </tr>
                                @foreach($pesanan->details as $item)
                                    <tr style="border-bottom: 1px solid #E5E7EB;">
                                        <td style="padding: 14px 16px; font-size: 13px; font-weight: 700; color: #111827;">
                                            {{ $item->produk->nama_produk ?? '-' }}
                                            <span style="display: block; font-size: 11px; color: #6B7280; font-weight: 500; margin-top: 2px;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }} / unit</span>
                                        </td>
                                        <td align="center" style="padding: 14px 16px; font-size: 13px; font-weight: 800; color: #111827;">{{ $item->jumlah }}</td>
                                        <td align="right" style="padding: 14px 16px; font-size: 13px; font-weight: 800; color: #33116C;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Bill Summary -->
                    <tr>
                        <td style="padding: 12px 24px 24px 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="300" align="right">
                                <tr>
                                    <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #6B7280;">Subtotal Belanja</td>
                                    <td align="right" style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #111827;">Rp {{ number_format($pesanan->total_belanja, 0, ',', '.') }}</td>
                                </tr>
                                @if($pesanan->biaya_pengiriman > 0)
                                <tr>
                                    <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #6B7280;">Ongkos Kirim</td>
                                    <td align="right" style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #111827;">Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($pesanan->diskon_voucher > 0)
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #E53E3E;">Diskon Voucher</td>
                                        <td align="right" style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #E53E3E;">- Rp {{ number_format($pesanan->diskon_voucher, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2" style="padding: 10px 0;">
                                        <div style="border-top: 1px solid #E5E7EB;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; font-weight: 800; color: #33116C;">TOTAL TAGIHAN</td>
                                    <td align="right" style="font-size: 16px; font-weight: 800; color: #33116C;">Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer Section -->
                    <tr>
                        <td align="center" style="background-color: #F9FAFB; padding: 24px; border-top: 1px solid #E5E7EB; color: #9CA3AF;">
                            <p style="margin: 0; font-size: 12px; font-weight: 700; color: #6B7280;">Terima kasih atas kepercayaan Anda berbelanja di Borma Toserba!</p>
                            <p style="margin: 6px 0 0 0; font-size: 11px; line-height: 1.5;">Harap simpan email invoice ini sebagai bukti pembelian resmi. Jika Anda memiliki pertanyaan, silakan hubungi customer service kami.</p>
                            <div style="border-top: 1px solid #E5E7EB; margin: 16px 0; width: 100px;"></div>
                            <p style="margin: 0; font-size: 10px; font-weight: 600; letter-spacing: 0.5px;">&copy; {{ date('Y') }} Borma Toserba. Hak Cipta Dilindungi.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
