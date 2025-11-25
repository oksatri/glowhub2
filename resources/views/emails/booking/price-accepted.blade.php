<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Revision Accepted</title>
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
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
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
            border-left: 4px solid #00b894;
        }
        .info-item {
            margin: 10px 0;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            color: #00b894;
            display: inline-block;
            width: 120px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #d4edda;
            color: #155724;
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
        .price-confirmed {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #00b894;
            text-align: center;
        }
        .final-price {
            font-size: 2em;
            font-weight: bold;
            color: #00b894;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Price Revision Accepted!</h1>
        <p>The customer has accepted your revised price</p>
    </div>

    <div class="content">
        <p>Dear {{ $muaName }},</p>

        <p>Great news! {{ $customerName }} has accepted your revised price for the booking.</p>

        <div class="status-badge">
            ✅ Status: Confirmed
        </div>

        <h2>Booking Details</h2>

        <div class="booking-info">
            <div class="info-item">
                <span class="info-label">Booking ID:</span>
                {{ $bookingId }}
            </div>
            <div class="info-item">
                <span class="info-label">Customer:</span>
                {{ $customerName }}
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

        <div class="price-confirmed">
            <h3>💰 Final Confirmed Price</h3>
            <div class="final-price">
                Rp {{ number_format($finalPrice, 0, ',', '.') }}
            </div>
            <p>This booking is now confirmed with the revised price</p>
        </div>

        <p><strong>Next Steps:</strong></p>
        <ol>
            <li>Contact the customer to confirm final details</li>
            <li>Arrange payment method and schedule</li>
            <li>Prepare for the makeup session</li>
        </ol>

        <p>Congratulations on securing this booking!</p>

        <p>Best regards,<br>The GlowHub Team</p>

        <div class="footer">
            <p>This is an automated notification from <strong>GlowHub Platform</strong></p>
            <p>&copy; {{ date('Y') }} GlowHub. Your Beauty & Wellness Partner.</p>
        </div>
    </div>
</body>
</html>
