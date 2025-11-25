<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Request Submitted</title>
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
        .next-steps {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #00b894;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Booking Request Submitted!</h1>
        <p>Your booking request has been successfully submitted</p>
    </div>

    <div class="content">
        <p>Dear {{ $customerName }},</p>

        <p>Thank you for choosing GlowHub! Your booking request has been successfully submitted and is now being reviewed by the MUA.</p>

        <div class="status-badge">
            📋 Status: Pending Confirmation
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

        <div class="next-steps">
            <h3>What happens next?</h3>
            <ol>
                <li>The MUA will review your booking request</li>
                <li>You will receive a confirmation, price revision, or rejection within 24-48 hours</li>
                <li>If confirmed, you'll receive payment instructions and further details</li>
            </ol>
            <p><strong>Please keep your Booking ID ({{ $bookingId }}) for future reference.</strong></p>
        </div>

        <p>If you have any questions or need to make changes to your booking, please don't hesitate to contact us.</p>

        <p>Best regards,<br>The GlowHub Team</p>

        <div class="footer">
            <p>This is an automated notification from <strong>GlowHub Platform</strong></p>
            <p>&copy; {{ date('Y') }} GlowHub. Your Beauty & Wellness Partner.</p>
        </div>
    </div>
</body>
</html>
