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
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
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
            border-left: 4px solid #ff6b6b;
        }
        .info-item {
            margin: 10px 0;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            color: #ff6b6b;
            display: inline-block;
            width: 120px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin: 20px 10px 20px 0;
            font-weight: bold;
        }
        .btn-primary {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
        }
        .btn-warning {
            background: linear-gradient(135deg, #fdcb6e 0%, #f39c12 100%);
        }
        .btn-danger {
            background: linear-gradient(135deg, #d63031 0%, #e17055 100%);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
        .price-estimate {
            background: #e8f5e8;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #00b894;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎨 New Booking Request!</h1>
        <p>You have a new booking request from a customer</p>
    </div>

    <div class="content">
        <h2>Customer Information</h2>

        <div class="booking-info">
            <div class="info-item">
                <span class="info-label">Name:</span>
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
                <span class="info-label">Address:</span>
                {{ $customerAddress }}
            </div>
        </div>

        <h2>Booking Details</h2>

        <div class="booking-info">
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

        @if($services)
            <h3>Additional Services:</h3>
            <ul>
                @foreach($services as $service)
                    <li>{{ $service }}</li>
                @endforeach
            </ul>
        @endif

        <div class="price-estimate">
            <strong>Estimated Price: Rp {{ number_format($estimatedPrice, 0, ',', '.') }}</strong>
        </div>

        <p><strong>Action Required:</strong> Please review this booking request and confirm, revise the price, or reject it.</p>

        <a href="{{ route('mua.bookings.confirm', $booking->id) }}" class="btn btn-primary">Confirm Booking</a>
        <a href="{{ route('mua.bookings.confirm', $booking->id) }}" class="btn btn-warning">Revise Price</a>
        <a href="{{ route('mua.bookings.confirm', $booking->id) }}" class="btn btn-danger">Reject Booking</a>

        <div class="footer">
            <p>This is an automated notification from GlowHub Booking System</p>
            <p>&copy; {{ date('Y') }} GlowHub. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
