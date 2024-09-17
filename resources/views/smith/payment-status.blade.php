<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* General styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
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
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }

        .status-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            transition: transform 0.2s ease-in-out;
        }

        .status-card:hover {
            transform: scale(1.02);
        }

        .status-card h2 {
            margin-bottom: 15px;
            font-size: 22px;
            color: #3498db;
        }

        .transaction-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        .transaction-info strong {
            color: #2c3e50;
        }

        .status-info h3 {
            margin-top: 20px;
            font-size: 18px;
        }

        .status-text {
            color: #e74c3c;
            font-weight: bold;
        }

        /* Conditional status color */
        .status-text:after {
            content: ' Pending';
        }

        .status-text.complete:after {
            content: ' Complete';
            color: #2ecc71;
        }

        .status-text.failed:after {
            content: ' Failed';
            color: #e74c3c;
        }

        /* Footer Styling */
        footer {
            background-color: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav>
        <h1>Payment Status</h1>
    </nav>

    <!-- Payment Status Section -->
    <section class="payment-status">
        @if($fetchpurchase->count() > 0)
            @foreach($fetchpurchase as $purchase)
                <div class="status-card">
                    <h2>Transaction Details</h2>
                    <div class="transaction-info">
                        <p><strong>Transaction ID:</strong> {{ $purchase->jewel_id }}</p>
                        <p><strong>Amount:</strong> ${{ $purchase->amount }}</p>
                        <p><strong>Date:</strong> {{ $purchase->created_at->format('Y-m-d') }}</p>
                    </div>
                    <div class="status-info">
                        <h3>Status: <span class="status-text {{ strtolower($purchase->status) }}">{{ ucfirst($purchase->status) }}</span></h3>
                    </div>
                </div>
            @endforeach
        @else
            <p>No purchases found.</p>
        @endif
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2024 Payment Solutions</p>
    </footer>

</body>

</html>
