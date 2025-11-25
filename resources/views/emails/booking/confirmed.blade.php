<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
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
        .mua-note {
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
        <h1>🎉 Booking Confirmed!</h1>
        <p>Your booking has been confirmed by the MUA</p>
    </div>

    <div class="content">
        <p>Dear {{ $customerName }},</p>

        <p>Great news! Your booking request has been confirmed by {{ $muaName }}.</p>

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

        @if($muaNote)
            <div class="mua-note">
                <h3>Message from MUA:</h3>
                <p>{{ $muaNote }}</p>
            </div>
        @endif

        <p><strong>Next Steps:</strong></p>
        <ol>
            <li>Please prepare payment according to the agreed price</li>
            <li>Arrive at the location 15 minutes before your scheduled time</li>
            <li>Bring any reference photos if you have specific requirements</li>
        </ol>

        <p>If you need to make any changes to your booking, please contact us as soon as possible.</p>

        <p>Best regards,<br>The {{ $muaName }} Team & GlowHub</p>

        <div class="footer">
            <p>This is an automated notification from GlowHub Booking System</p>
            <p>&copy; {{ date('Y') }} GlowHub. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
