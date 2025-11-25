<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Accepted - GlowHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .response-container {
            max-width: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
        }
        .header-section {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
            padding: 40px;
        }
        .content-section {
            padding: 40px;
        }
        .success-icon {
            font-size: 4em;
            color: #00b894;
            margin: 20px 0;
        }
        .booking-details {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            text-align: left;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #666;
        }
        .detail-value {
            font-weight: 500;
            color: #333;
        }
        .final-price {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin: 30px 0;
        }
        .price-amount {
            font-size: 2.5em;
            font-weight: bold;
            margin: 10px 0;
        }
        .btn-home {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            margin: 20px 10px;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: white;
        }
    </style>
</head>
<body>
    <div class="response-container">
        <div class="header-section">
            <h1><i class="fas fa-check-circle"></i> Price Accepted!</h1>
            <p>Your price revision has been accepted by the customer</p>
        </div>

        <div class="content-section">
            <div class="success-icon">
                <i class="fas fa-thumbs-up"></i>
            </div>

            <h2>Congratulations!</h2>
            <p>The booking is now confirmed with your revised price. You will receive further details from the customer soon.</p>

            <div class="booking-details">
                <h4><i class="fas fa-info-circle"></i> Booking Details</h4>
                <div class="detail-item">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">BK{{ $booking->id }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Customer:</span>
                    <span class="detail-value">{{ $booking->customer_name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Service:</span>
                    <span class="detail-value">{{ $booking->service->service_name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $booking->selected_date->format('d M Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">{{ $booking->selected_time }}</span>
                </div>
            </div>

            <div class="final-price">
                <h4><i class="fas fa-money-bill-wave"></i> Final Confirmed Price</h4>
                <div class="price-amount">
                    Rp {{ number_format($booking->revised_price, 0, ',', '.') }}
                </div>
            </div>

            <div class="next-steps">
                <h4><i class="fas fa-arrow-right"></i> What's Next?</h4>
                <p>The customer has been notified of the confirmation. You can expect them to contact you for further arrangements.</p>
            </div>

            <a href="{{ route('home') }}" class="btn-home">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>
