<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Rejected - GlowHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #d63031 0%, #e17055 100%);
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
            background: linear-gradient(135deg, #d63031 0%, #e17055 100%);
            color: white;
            padding: 40px;
        }
        .content-section {
            padding: 40px;
        }
        .info-icon {
            font-size: 4em;
            color: #d63031;
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
        .next-steps {
            background: #fff5f5;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            border-left: 5px solid #d63031;
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
            <h1><i class="fas fa-info-circle"></i> Price Revision Rejected</h1>
            <p>The customer has rejected your price revision</p>
        </div>

        <div class="content-section">
            <div class="info-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

            <h2>What Happened?</h2>
            <p>The customer has rejected your revised price. The booking status has been changed back to pending for your review.</p>

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

            <div class="next-steps">
                <h4><i class="fas fa-arrow-right"></i> What You Can Do Next</h4>
                <ol>
                    <li>Review the original price and consider if you can accommodate the customer's budget</li>
                    <li>Contact the customer directly to discuss alternative options</li>
                    <li>Submit a new price revision if possible</li>
                    <li>If no agreement can be reached, you may need to reject the booking</li>
                </ol>
                <p><strong>You have 24 hours to respond with a new proposal or decision.</strong></p>
            </div>

            <a href="{{ route('home') }}" class="btn-home">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>
