@extends('front._parts.master')

@section('title', 'Invoice - ' . $invoiceNumber)

@push('styles')
<style>
    .invoice-container {
        max-width: 900px;
        margin: 40px auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .invoice-header {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        padding: 40px;
        text-align: center;
    }

    .invoice-header h1 {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
    }

    .invoice-header p {
        font-size: 16px;
        opacity: 0.9;
        margin: 5px 0 0;
    }

    .invoice-info {
        background: #f8f9fa;
        padding: 30px;
        border-bottom: 3px solid #ff6b6b;
    }

    .invoice-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .invoice-meta-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #ff6b6b;
    }

    .invoice-meta-item strong {
        color: #ff6b6b;
        display: block;
        margin-bottom: 5px;
    }

    .invoice-content {
        padding: 40px;
    }

    .section-title {
        color: #ff6b6b;
        font-size: 24px;
        font-weight: 600;
        border-bottom: 2px solid #ff6b6b;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }

    .booking-details {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .detail-row:last-child {
        border-bottom: none;
        font-weight: bold;
        font-size: 20px;
        color: #ff6b6b;
        margin-top: 10px;
        padding-top: 20px;
        border-top: 2px solid #ff6b6b;
    }

    .payment-methods {
        margin-top: 30px;
    }

    .payment-method {
        background: white;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: #ff6b6b;
        box-shadow: 0 5px 20px rgba(255,107,107,0.1);
        transform: translateY(-2px);
    }

    .payment-method h4 {
        color: #ff6b6b;
        font-size: 18px;
        margin: 0 0 10px;
    }

    .account-info {
        background: #f0f0f0;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
        font-family: 'Courier New', monospace;
        font-size: 14px;
        border-left: 4px solid #ff6b6b;
    }

    .payment-steps {
        margin: 15px 0;
    }

    .payment-steps ol {
        padding-left: 20px;
    }

    .payment-steps li {
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .urgent-notice {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 10px;
        padding: 20px;
        margin: 30px 0;
        border-left: 5px solid #f39c12;
    }

    .urgent-notice h4 {
        color: #856404;
        margin: 0 0 10px;
        font-size: 18px;
    }

    .urgent-notice p {
        margin: 0;
        color: #856404;
        line-height: 1.6;
    }

    .action-buttons {
        text-align: center;
        margin: 40px 0;
    }

    .btn {
        display: inline-block;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        padding: 15px 30px;
        text-decoration: none;
        border-radius: 30px;
        font-weight: 600;
        font-size: 16px;
        margin: 10px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255,107,107,0.3);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-paid {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    @media (max-width: 768px) {
        .invoice-container {
            margin: 20px;
            border-radius: 10px;
        }

        .invoice-header {
            padding: 30px 20px;
        }

        .invoice-header h1 {
            font-size: 24px;
        }

        .invoice-content {
            padding: 20px;
        }

        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .detail-row span:last-child {
            font-weight: 600;
        }

        .btn {
            display: block;
            margin: 10px 0;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="invoice-container">
    <!-- Header -->
    <div class="invoice-header">
        <h1>🧾 INVOICE TAGIHAN</h1>
        <p>GlowHub Beauty & Wellness Platform</p>
    </div>

    <!-- Invoice Info -->
    <div class="invoice-info">
        <h2 style="color: #ff6b6b; margin: 0 0 20px; font-size: 28px;">Invoice #{{ $invoiceNumber }}</h2>
        <div class="invoice-meta">
            <div class="invoice-meta-item">
                <strong>Tanggal Invoice</strong>
                {{ now()->format('d M Y H:i') }}
            </div>
            <div class="invoice-meta-item">
                <strong>Jatuh Tempo</strong>
                {{ now()->addDays(1)->format('d M Y H:i') }}
            </div>
            <div class="invoice-meta-item">
                <strong>Status Pembayaran</strong>
                @if($booking->bookingPayment && $booking->bookingPayment->status === 'paid')
                    <span class="status-badge status-paid">Sudah Dibayar</span>
                @else
                    <span class="status-badge status-pending">Menunggu Pembayaran</span>
                @endif
            </div>
            <div class="invoice-meta-item">
                <strong>No. Referensi</strong>
                {{ $booking->bookingPayment->payment_reference ?? 'INV-' . str_pad($booking->id, 8, '0', STR_PAD_LEFT) . '-' . date('Ymd') }}
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="invoice-content">
        <!-- Customer Info -->
        <div class="section-title">👤 Informasi Customer</div>
        <div class="booking-details">
            <div class="detail-row">
                <span>Nama Customer:</span>
                <span>{{ $booking->customer_name }}</span>
            </div>
            <div class="detail-row">
                <span>Email:</span>
                <span>{{ $booking->customer_email }}</span>
            </div>
            <div class="detail-row">
                <span>WhatsApp:</span>
                <span>{{ $booking->customer_whatsapp }}</span>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="section-title">📋 Detail Booking</div>
        <div class="booking-details">
            <div class="detail-row">
                <span>ID Booking:</span>
                <span>BK{{ $booking->id }}</span>
            </div>
            <div class="detail-row">
                <span>MUA:</span>
                <span>{{ $booking->mua->name ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span>Layanan:</span>
                <span>{{ $booking->service->service_name ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span>Tanggal:</span>
                <span>{{ $booking->selected_date->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span>Waktu:</span>
                <span>{{ $booking->selected_time }}</span>
            </div>
            <div class="detail-row">
                <span>Lokasi:</span>
                <span>{{ $booking->customer_address }}</span>
            </div>
            @if($booking->services)
                <div class="detail-row">
                    <span>Additional Services:</span>
                    <span>{{ is_array($booking->services) ? implode(', ', $booking->services) : $booking->services }}</span>
                </div>
            @endif
            <div class="detail-row">
                <span>Total Pembayaran:</span>
                <span>Rp {{ number_format($booking->revised_price ?? $booking->service_price ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Urgent Notice -->
        @if($booking->bookingPayment && $booking->bookingPayment->status !== 'paid')
            <div class="urgent-notice">
                <h4>⚠️ PENTING: Batas Pembayaran</h4>
                <p>Silakan lakukan pembayaran sebelum <strong>{{ now()->addDays(1)->format('d M Y H:i') }}</strong> untuk mengkonfirmasi booking Anda. Jika pembayaran tidak dilakukan dalam batas waktu, booking dapat dibatalkan secara otomatis.</p>
            </div>
        @endif

        <!-- Payment Methods -->
        @if($booking->bookingPayment && $booking->bookingPayment->status !== 'paid')
            <div class="section-title">💳 Metode Pembayaran</div>
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
                                <ol>
                                    @foreach($method->instructions['steps'] as $step)
                                        <li>{{ $step }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="javascript:window.print()" class="btn">
                🖨️ Cetak Invoice
            </a>
            <a href="mailto:support@glowhub.id?subject=Pertanyaan Invoice {{ $invoiceNumber }}" class="btn btn-secondary">
                💬 Hubungi Support
            </a>
        </div>
    </div>
</div>
@endsection
