<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Revision</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #fdcb6e 0%, #f39c12 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .booking-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f39c12;
        }
        .info-item {
            margin: 10px 0;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            color: #f39c12;
            display: inline-block;
            width: 120px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #fff3cd;
            color: #856404;
            border-radius: 20px;
            font-weight: bold;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
        .price-comparison {
            background: #fff5e6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f39c12;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
        }
        .price-original {
            text-decoration: line-through;
            color: #999;
        }
        .price-new {
            font-weight: bold;
            color: #f39c12;
            font-size: 1.2em;
        }
        .price-note {
            background: #e8f5e8;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #00b894;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        .btn-accept {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
        }
        .btn-reject {
            background: linear-gradient(135deg, #d63031 0%, #e17055 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>💰 Price Revision</h1>
        <p>{{ $muaName }} has revised the price for your booking</p>
    </div>

    <div class="content">
        <p>Dear {{ $customerName }},</p>

        <p>{{ $muaName }} has reviewed your booking request and proposed a revised price.</p>

        <div class="status-badge">
            💵 Status: Price Revision Proposed
        </div>

        <h2>Booking Details</h2>

        <div class="booking-info">
            <div class="info-item">
                <span class="info-label">Booking ID:</span>
                {{ $bookingId }}
            </div>
            <div class="info-item">
                <span class="info-label">MUA:</span>
                {{ $muaName }}
            </div>
            <div class="info-item">
                <span class="info-label">Service:</span>
                {{ $serviceName }}
            </div>
            <div class="info-item">
                <span class="info-label">Date:</span>
                {{ $selectedDate }}
            </div>
            <div class="info-item">
                <span class="info-label">Time:</span>
                {{ $selectedTime }}
            </div>
        </div>

        <div class="price-comparison">
            <h3>Price Comparison</h3>
            <div class="price-row">
                <span>Original Price:</span>
                <span class="price-original">Rp {{ number_format($originalPrice, 0, ',', '.') }}</span>
            </div>
            <div class="price-row">
                <span>Revised Price:</span>
                <span class="price-new">Rp {{ number_format($revisedPrice, 0, ',', '.') }}</span>
            </div>
            <div class="price-row">
                <span>Difference:</span>
                <span>Rp {{ number_format($revisedPrice - $originalPrice, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="price-note">
            <h3>Message from MUA:</h3>
            <p>{{ $priceNote }}</p>
        </div>

        <div class="action-buttons">
            <h3>Your Action Required</h3>
            <p>Please choose whether to accept or reject the revised price:</p>
            <a href="{{ route('booking.price.accept', $booking->id) }}" class="btn btn-accept">Accept Price</a>
            <a href="{{ route('booking.price.reject', $booking->id) }}" class="btn btn-reject">Reject Price</a>
        </div>

        <p><strong>Please respond within 24 hours</strong> to confirm your decision. If we don't hear from you, the booking will be automatically cancelled.</p>

        <p>If you have any questions about the price revision, feel free to contact us.</p>

        <p>Best regards,<br>The {{ $muaName }} Team & GlowHub</p>

        <div class="footer">
            <p>This is an automated notification from <strong>GlowHub Platform</strong></p>
            <p>&copy; {{ date('Y') }} GlowHub. Your Beauty & Wellness Partner.</p>
        </div>
    </div>
</body>
</html>
