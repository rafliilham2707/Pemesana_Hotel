<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Voucher Hotel - {{ $booking->booking_code }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Mono:wght@700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #0f172a; padding: 40px 20px; }
        .voucher-container { max-width: 800px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background: #0284c7; color: white; padding: 32px; display: flex; justify-content: space-between; align-items: flex-start; }
        .logo { font-size: 24px; font-weight: 800; display: flex; align-items: center; gap: 8px; }
        .booking-badge { background: rgba(255, 255, 255, 0.2); padding: 8px 16px; border-radius: 8px; text-align: right; }
        .code { font-family: 'Space Mono', monospace; font-size: 18px; font-weight: 700; }
        .content { padding: 32px; }
        .hotel-title { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .hotel-address { color: #64748b; font-size: 13px; margin-bottom: 24px; }
        .dates-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .date-box label { font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 600; }
        .date-box .val { font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 4px; }
        .date-box .time { font-size: 12px; color: #64748b; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; font-size: 13px; }
        .details-table th, .details-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: left; }
        .details-table th { color: #64748b; font-weight: 600; font-size: 12px; }
        .total-row td { font-size: 15px; font-weight: 700; color: #0284c7; border-top: 2px solid #e2e8f0; }
        .policy-box { background: #f8fafc; border-left: 4px solid #0284c7; padding: 16px; border-radius: 4px; font-size: 12px; color: #475569; margin-bottom: 24px; }
        .footer { padding: 24px 32px; background: #f8fafc; border-top: 1px dashed #cbd5e1; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #64748b; }
        .print-btn { display: inline-block; background: #0284c7; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; border: none; cursor: pointer; }
        .print-btn:hover { background: #0369a1; }
        @media print {
            body { padding: 0; background: white; }
            .voucher-container { border: none; box-shadow: none; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="max-width: 800px; margin: 0 auto 20px auto; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('account.bookings') }}" style="color: #64748b; text-decoration: none; font-size: 14px;">&larr; Kembali ke Pesanan</a>
        <button class="print-btn" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>

    <div class="voucher-container">
        {{-- Header --}}
        <div class="header">
            <div>
                <div class="logo">🏨 StayHub</div>
                <div style="font-size: 13px; opacity: 0.9; margin-top: 4px;">E-Voucher Pemesanan Hotel Resmi</div>
            </div>
            <div class="booking-badge">
                <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">KODE BOOKING</div>
                <div class="code">{{ $booking->booking_code }}</div>
                <div style="font-size: 11px; margin-top: 4px; color: #86efac; font-weight: 700;">STATUS: LUNAS</div>
            </div>
        </div>

        {{-- Content --}}
        <div class="content">
            <h1 class="hotel-title">{{ $booking->hotel->name }}</h1>
            <p class="hotel-address">{{ $booking->hotel->address }}, {{ $booking->hotel->city->name }}, Indonesia</p>

            {{-- Check-in / Check-out Grid --}}
            <div class="dates-grid">
                <div class="date-box">
                    <label>Tanggal Check-in</label>
                    <div class="val">{{ \Carbon\Carbon::parse($booking->check_in)->translatedFormat('l, d F Y') }}</div>
                    <div class="time">Mulai {{ $booking->hotel->check_in_time ?? '14:00' }} WIB</div>
                </div>
                <div class="date-box">
                    <label>Tanggal Check-out</label>
                    <div class="val">{{ \Carbon\Carbon::parse($booking->check_out)->translatedFormat('l, d F Y') }}</div>
                    <div class="time">Sebelum {{ $booking->hotel->check_out_time ?? '12:00' }} WIB</div>
                </div>
            </div>

            {{-- Reservation Details --}}
            <table class="details-table">
                <thead>
                    <tr>
                        <th>Rincian Tamu & Kamar</th>
                        <th style="text-align: right;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Tamu Utama</td>
                        <td style="text-align: right; font-weight: 600;">{{ $booking->guest_name }}</td>
                    </tr>
                    <tr>
                        <td>Kontak Tamu</td>
                        <td style="text-align: right;">{{ $booking->guest_email }} | {{ $booking->guest_phone }}</td>
                    </tr>
                    <tr>
                        <td>Tipe Kamar</td>
                        <td style="text-align: right; font-weight: 600;">{{ $booking->roomType->name }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Kamar & Durasi</td>
                        <td style="text-align: right;">{{ $booking->rooms }} Kamar, {{ $booking->nights }} Malam ({{ $booking->guests }} Tamu)</td>
                    </tr>
                    @if($booking->special_request)
                    <tr>
                        <td>Permintaan Khusus</td>
                        <td style="text-align: right; font-style: italic;">"{{ $booking->special_request }}"</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Biaya Kamar & Pajak</td>
                        <td style="text-align: right;">{{ format_rupiah($booking->subtotal + $booking->tax + $booking->service_fee) }}</td>
                    </tr>
                    @if($booking->discount > 0)
                    <tr>
                        <td>Diskon Voucher ({{ $booking->voucher?->code }})</td>
                        <td style="text-align: right; color: #16a34a;">- {{ format_rupiah($booking->discount) }}</td>
                    </tr>
                    @endif
                    <tr class="total-row">
                        <td>Total Pembayaran Lunas</td>
                        <td style="text-align: right;">{{ format_rupiah($booking->total) }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Hotel Policy Note --}}
            <div class="policy-box">
                <strong>Ketentuan Check-in:</strong>
                <p style="margin-top: 4px;">
                    Tunjukkan e-voucher ini beserta KTP / Paspor asli yang berlaku saat check-in di meja resepsionis hotel.
                    {{ $booking->hotel->policy ?? 'Deposit mungkin diperlukan saat check-in sesuai kebijakan pihak hotel.' }}
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <div>
                Diterbitkan secara otomatis oleh <strong>StayHub Platform</strong> pada {{ now()->translatedFormat('d F Y H:i') }} WIB.
            </div>
            <div>
                Bantuan 24/7: support@stayhub.id | 0800-1234-5678
            </div>
        </div>
    </div>
</body>
</html>

