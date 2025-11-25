<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - GlowHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .confirmation-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header-section {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content-section {
            padding: 40px;
        }
        .info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            border-left: 5px solid #ff6b6b;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
            min-width: 150px;
        }
        .info-value {
            font-weight: 500;
            color: #333;
            text-align: right;
        }
        .price-section {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            text-align: center;
        }
        .price-amount {
            font-size: 2.5em;
            font-weight: bold;
            margin: 10px 0;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        .btn-action {
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-confirm {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
        }
        .btn-revise {
            background: linear-gradient(135deg, #fdcb6e 0%, #f39c12 100%);
            color: white;
        }
        .btn-reject {
            background: linear-gradient(135deg, #d63031 0%, #e17055 100%);
            color: white;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .form-section {
            display: none;
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin: 20px 0;
        }
        .form-section.active {
            display: block;
        }
        .services-list {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
        }
        .service-item {
            padding: 8px 0;
            border-bottom: 1px solid #d4edda;
        }
        .service-item:last-child {
            border-bottom: none;
        }
        @media (max-width: 768px) {
            .confirmation-container {
                margin: 20px;
                border-radius: 15px;
            }
            .action-buttons {
                flex-direction: column;
            }
            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="header-section">
            <h1><i class="fas fa-calendar-check"></i> Booking Confirmation</h1>
            <p>Review and respond to this booking request</p>
        </div>

        <div class="content-section">
            <!-- Customer Information -->
            <div class="info-card">
                <h3><i class="fas fa-user"></i> Customer Information</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $booking->customer_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $booking->customer_email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">WhatsApp:</span>
                    <span class="info-value">{{ $booking->customer_whatsapp }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Address:</span>
                    <span class="info-value">{{ $booking->customer_address }}</span>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="info-card">
                <h3><i class="fas fa-info-circle"></i> Booking Details</h3>
                <div class="info-item">
                    <span class="info-label">Service:</span>
                    <span class="info-value">{{ $booking->service->service_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date:</span>
                    <span class="info-value">{{ $booking->selected_date->format('d M Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Time:</span>
                    <span class="info-value">{{ $booking->selected_time }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Distance:</span>
                    <span class="info-value">{{ $booking->distance_km }} km</span>
                </div>
            </div>

            <!-- Additional Services -->
            @if($booking->services)
                <div class="services-list">
                    <h4><i class="fas fa-list"></i> Additional Services</h4>
                    @foreach($booking->services as $service)
                        <div class="service-item">
                            <i class="fas fa-check-circle text-success"></i> {{ $service }}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Price Section -->
            <div class="price-section">
                <h3><i class="fas fa-money-bill-wave"></i> Estimated Price</h3>
                <div class="price-amount">
                    Rp {{ number_format($estimatedPrice, 0, ',', '.') }}
                </div>
                <p>This is the estimated price based on selected services and location</p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button type="button" class="btn-action btn-confirm" onclick="showConfirmForm()">
                    <i class="fas fa-check"></i> Confirm Booking
                </button>
                <button type="button" class="btn-action btn-revise" onclick="showReviseForm()">
                    <i class="fas fa-edit"></i> Revise Price
                </button>
                <button type="button" class="btn-action btn-reject" onclick="showRejectForm()">
                    <i class="fas fa-times"></i> Reject Booking
                </button>
            </div>

            <!-- Confirm Form -->
            <div id="confirmForm" class="form-section">
                <h4><i class="fas fa-check-circle text-success"></i> Confirm Booking</h4>
                <p>Are you sure you want to confirm this booking? The customer will be notified immediately.</p>

                <form action="{{ route('mua.bookings.confirm', $booking->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="mua_note" class="form-label">Optional message to customer:</label>
                        <textarea class="form-control" id="mua_note" name="mua_note" rows="3"
                                  placeholder="Add any special instructions or notes for the customer..."></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Yes, Confirm Booking
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="hideAllForms()">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Revise Price Form -->
            <div id="reviseForm" class="form-section">
                <h4><i class="fas fa-edit text-warning"></i> Revise Price</h4>
                <p>Propose a new price for this booking. The customer will receive your proposal for approval.</p>

                <form action="{{ route('mua.bookings.revise-price', $booking->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="revised_price" class="form-label">Revised Price (Rp):</label>
                        <input type="number" class="form-control" id="revised_price" name="revised_price"
                               value="{{ $estimatedPrice }}" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_note" class="form-label">Reason for revision:</label>
                        <textarea class="form-control" id="price_note" name="price_note" rows="3"
                                  placeholder="Explain why you're revising the price..." required></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-send"></i> Send Price Revision
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="hideAllForms()">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Reject Form -->
            <div id="rejectForm" class="form-section">
                <h4><i class="fas fa-times-circle text-danger"></i> Reject Booking</h4>
                <p>Are you sure you want to reject this booking? Please provide a reason for the customer.</p>

                <form action="{{ route('mua.bookings.reject', $booking->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Rejection Reason:</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"
                                  placeholder="Please explain why you're rejecting this booking..." required></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Yes, Reject Booking
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="hideAllForms()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function hideAllForms() {
            document.querySelectorAll('.form-section').forEach(form => {
                form.classList.remove('active');
            });
        }

        function showConfirmForm() {
            hideAllForms();
            document.getElementById('confirmForm').classList.add('active');
        }

        function showReviseForm() {
            hideAllForms();
            document.getElementById('reviseForm').classList.add('active');
        }

        function showRejectForm() {
            hideAllForms();
            document.getElementById('rejectForm').classList.add('active');
        }
    </script>
</body>
</html>
