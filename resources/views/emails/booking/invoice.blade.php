<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Tagihan - {{ $invoiceNumber }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 5px 0 0;
            opacity: 0.9;
        }
        .invoice-info {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 3px solid #ff6b6b;
        }
        .invoice-info h2 {
            color: #ff6b6b;
            margin: 0 0 15px;
            font-size: 24px;
        }
        .invoice-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .invoice-meta div {
            background: white;
            padding: 10px;
            border-radius: 5px;
        }
        .invoice-meta strong {
            color: #ff6b6b;
        }
        .content {
            padding: 30px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h3 {
            color: #ff6b6b;
            border-bottom: 2px solid #ff6b6b;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .booking-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .detail-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
            color: #ff6b6b;
        }
        .payment-methods {
            margin-top: 20px;
        }
        .payment-method {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .payment-method:hover {
            border-color: #ff6b6b;
            box-shadow: 0 2px 10px rgba(255,107,107,0.1);
        }
        .payment-method h4 {
            color: #ff6b6b;
            margin: 0 0 10px;
            font-size: 16px;
        }
        .payment-steps {
            margin: 10px 0;
            padding-left: 20px;
        }
        .payment-steps li {
            margin-bottom: 5px;
            font-size: 14px;
        }
        .account-info {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-family: monospace;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            text-align: center;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,107,107,0.3);
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .urgent {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .urgent h4 {
            color: #856404;
            margin: 0 0 10px;
        }
        .urgent p {
            margin: 0;
            color: #856404;
        }
        @media (max-width: 600px) {
            .invoice-meta {
                grid-template-columns: 1fr;
            }
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧾 INVOICE TAGIHAN</h1>
            <p>GlowHub Beauty & Wellness Platform</p>
        </div>

        <div class="invoice-info">
            <h2>Invoice #{{ $invoiceNumber }}</h2>
            <div class="invoice-meta">
                <div>
                    <strong>Tanggal Invoice:</strong><br>
                    {{ now()->format('d M Y H:i') }}
                </div>
                <div>
                    <strong>Jatuh Tempo:</strong><br>
                    {{ $dueDate }}
                </div>
                <div>
                    <strong>Customer:</strong><br>
                    {{ $customerName }}<br>
                    {{ $booking->customer_email }}
                </div>
                <div>
                    <strong>No. Referensi:</strong><br>
                    {{ $paymentReference }}
                </div>
            </div>
        </div>

        <div class="content">
            <div class="section">
                <h3>📋 Detail Booking</h3>
                <div class="booking-details">
                    <div class="detail-row">
                        <span>ID Booking:</span>
                        <span>BK{{ $booking->id }}</span>
                    </div>
                    <div class="detail-row">
                        <span>MUA:</span>
                        <span>{{ $muaName }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Layanan:</span>
                        <span>{{ $serviceName }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Tanggal:</span>
                        <span>{{ $selectedDate }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Waktu:</span>
                        <span>{{ $selectedTime }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Lokasi:</span>
                        <span>{{ $booking->customer_address }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Total Pembayaran:</span>
                        <span>Rp {{ number_format($finalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="urgent">
                <h4>⚠️ PENTING: Batas Pembayaran</h4>
                <p>Silakan lakukan pembayaran sebelum <strong>{{ $dueDate }}</strong> untuk mengkonfirmasi booking Anda. Jika pembayaran tidak dilakukan dalam batas waktu, booking dapat dibatalkan secara otomatis.</p>
            </div>

            <div class="section">
                <h3>💳 Metode Pembayaran</h3>
                <div class="payment-methods">
                    @foreach($paymentMethods as $method)
                        <div class="payment-method">
                            <h4>{{ $method->name }}</h4>
                            <p>{{ $method->description }}</p>

                            @if($method->instructions['account_name'] ?? false)
                                <div class="account-info">
                                    <strong>Rekening Tujuan:</strong><br>
                                    {{ $method->instructions['account_name'] }}<br>
                                    {{ $method->instructions['bank_name'] }}<br>
                                    No. {{ $method->instructions['account_number'] }}
                                </div>
                            @endif

                            @if($method->instructions['steps'] ?? false)
                                <div class="payment-steps">
                                    <strong>Cara Pembayaran:</strong>
                                    <ul>
                                        @foreach($method->instructions['steps'] as $step)
                                            <li>{{ $step }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="section">
                <h3>📱 Langkah Selanjutnya</h3>
                <ol>
                    <li>Pilih salah satu metode pembayaran di atas</li>
                    <li>Lakukan pembayaran sesuai dengan jumlah tagihan</li>
                    <li>Simpan bukti pembayaran Anda</li>
                    <li>Booking akan dikonfirmasi setelah pembayaran terverifikasi</li>
                </ol>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('front.booking.invoice', $booking->id) }}" class="btn">
                    📄 Lihat Invoice Online
                </a>
                <a href="mailto:support@glowhub.id" class="btn">
                    💬 Hubungi Support
                </a>
            </div>
        </div>

        <div class="footer">
            <p><strong>Terima kasih telah mempercayai GlowHub untuk kebutuhan beauty & wellness Anda!</strong></p>
            <p>Jika ada pertanyaan, jangan ragu menghubungi kami:</p>
            <p>📧 Email: support@glowhub.id | 📱 WhatsApp: +62 878-xxxx-xxxx</p>
            <hr style="margin: 15px 0; border: none; border-top: 1px solid #e0e0e0;">
            <p>This is an automated notification from <strong>GlowHub Platform</strong></p>
            <p>&copy; {{ date('Y') }} GlowHub. Your Beauty & Wellness Partner.</p>
        </div>
    </div>
</body>
</html>
