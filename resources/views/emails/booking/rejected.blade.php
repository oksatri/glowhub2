<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Update</title>
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
            background: linear-gradient(135deg, #d63031 0%, #e17055 100%);
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
            border-left: 4px solid #d63031;
        }
        .info-item {
            margin: 10px 0;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            color: #d63031;
            display: inline-block;
            width: 120px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #f8d7da;
            color: #721c24;
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
        .rejection-reason {
            background: #fff5f5;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #d63031;
        }
        .suggestions {
            background: #e8f5e8;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #00b894;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Booking Update</h1>
        <p>There's an update on your booking request</p>
    </div>

    <div class="content">
        <p>Dear {{ $customerName }},</p>

        <p>We regret to inform you that your booking request with {{ $muaName }} has been declined.</p>

        <div class="status-badge">
            ❌ Status: Rejected
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

        <div class="rejection-reason">
            <h3>Reason from MUA:</h3>
            <p>{{ $rejectionReason }}</p>
        </div>

        <div class="suggestions">
            <h3>What you can do next:</h3>
            <ul>
                <li>Browse other available MUAs on GlowHub</li>
                <li>Try booking for a different date or time</li>
                <li>Contact our support team for assistance</li>
            </ul>
        </div>

        <p>We understand this may be disappointing. Our team is here to help you find the perfect MUA for your special day.</p>

        <p>Best regards,<br>The GlowHub Team</p>

        <div class="footer">
            <p>This is an automated notification from <strong>GlowHub Platform</strong></p>
            <p>&copy; {{ date('Y') }} GlowHub. Your Beauty & Wellness Partner.</p>
        </div>
    </div>
</body>
</html>
