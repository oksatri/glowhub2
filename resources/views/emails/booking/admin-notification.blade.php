<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Request</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            border-left: 4px solid #667eea;
        }
        .info-item {
            margin: 10px 0;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            color: #667eea;
            display: inline-block;
            width: 120px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔔 New Booking Request</h1>
        <p>A customer has submitted a new booking request</p>
    </div>

    <div class="content">
        <h2>Booking Details</h2>

        <div class="booking-info">
            <div class="info-item">
                <span class="info-label">Booking ID:</span>
                #{{ $booking->id }}
            </div>
            <div class="info-item">
                <span class="info-label">Customer Name:</span>
                {{ $customerName }}
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                {{ $customerEmail }}
            </div>
            <div class="info-item">
                <span class="info-label">WhatsApp:</span>
                {{ $customerWhatsapp }}
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

        <p><strong>Action Required:</strong> Please review this booking request and take appropriate action.</p>

        <a href="{{ route('back.bookings.index') }}" class="btn">View Booking Details</a>

        <div class="footer">
            <p>This is an automated notification from <strong>GlowHub Platform</strong></p>
            <p>&copy; {{ date('Y') }} GlowHub. Your Beauty & Wellness Partner.</p>
        </div>
    </div>
</body>
</html>
