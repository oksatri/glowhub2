<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Revision Rejected</title>
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
        .next-steps {
            background: #fff5f5;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #d63031;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Price Revision Rejected</h1>
        <p>The customer has rejected your price revision</p>
    </div>

    <div class="content">
        <p>Dear {{ $muaName }},</p>

        <p>{{ $customerName }} has rejected your revised price for the booking.</p>

        <div class="status-badge">
            ⏳ Status: Pending Review
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

        <div class="next-steps">
            <h3>What you can do next:</h3>
            <ol>
                <li>Review the original price and consider if you can accommodate the customer's budget</li>
                <li>Contact the customer directly to discuss alternative options</li>
                <li>Submit a new price revision if possible</li>
                <li>If no agreement can be reached, you may need to reject the booking</li>
            </ol>
        </div>

        <p>The booking status has been changed back to pending. You have 24 hours to respond with a new proposal or decision.</p>

        <p>Best regards,<br>The GlowHub Team</p>

        <div class="footer">
            <p>This is an automated notification from <strong>GlowHub Platform</strong></p>
            <p>&copy; {{ date('Y') }} GlowHub. Your Beauty & Wellness Partner.</p>
        </div>
    </div>
</body>
</html>
