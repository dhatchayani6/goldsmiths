<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* General styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Navbar styling */
        nav {
            background-color: #2c3e50;
            padding: 15px;
            color: #fff;
            text-align: center;
        }

        nav h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        /* Payment Status Section */
        .payment-status {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .status-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .status-card h2 {
            margin-bottom: 15px;
            font-size: 22px;
            color: #3498db;
        }

        .status-text {
            font-weight: bold;
        }

        .status-text.pending {
            color: #f39c12; /* Light yellow */
        }

        .status-text.complete {
            color: #2ecc71; /* Green */
        }

        .status-text.failed {
            color: #e74c3c; /* Red */
        }

        /* Footer Styling */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .payment-status {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
@include('smith.navabr')

    <!-- Payment Status Section -->
    <section class="payment-status">
        @if($fetchpurchase->count() > 0)
            <div class="row">
                @foreach($fetchpurchase as $purchase)
                    <div class="col-md-6">
                        <div class="status-card">
                            <h2>Transaction Details</h2>
                            <div class="transaction-info">
                                <p><strong>User ID:</strong> {{ $purchase->user_id }}</p>
                                <p><strong>Transaction ID:</strong> {{ $purchase->razorpay_payment_id }}</p>
                                <p><strong>Amount:</strong> ${{ $purchase->total_price}}</p>
                            </div>
                            <div class="status-info">
                                <h3>Status: <span class="status-text text-success {{ strtolower($purchase->status) }}">{{ ucfirst($purchase->status) }}</span></h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No purchases found.</p>
        @endif
    </section> 

    <!-- Footer -->
    <footer>
        <p>© 2024 Payment Solutions</p>
    </footer>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
