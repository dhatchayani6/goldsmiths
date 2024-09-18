<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            overflow-x: hidden;
        }

        /* Navbar styling */
        nav {
            background-color: #2c3e50;
            padding: 15px;
            color: #fff;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .status-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-left: 5px solid #3498db;
        }

        .status-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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
            font-weight: bold;
            transition: color 0.3s ease;
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
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }

        /* Edit Status Form */
        .edit-form {
            margin-top: 20px;
            animation: slideIn 0.5s ease-in-out;
        }

        /* Slide-in animation */
        @keyframes slideIn {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .edit-form select,
        .edit-form button {
            margin-top: 10px;
        }

        .edit-form button {
            background-color: #3498db;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-form button:hover {
            background-color: #2980b9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #2c3e50;
        }

        .form-select {
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: #fff;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-size: 16px;
        }

        .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
            outline: none;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .payment-status {
                padding: 10px;
            }

            .status-card {
                padding: 15px;
            }
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
                        <p><strong>Amount:</strong> ${{ number_format($purchase->amount, 2) }}</p>
                        <p><strong>Date:</strong> {{ $purchase->created_at->format('Y-m-d') }}</p>
                    </div>
                    <div class="status-info">
                        <h3>Status: <span class="status-text {{ strtolower($purchase->status) }}"></span></h3>
                    </div>
                    <!-- Edit Status Form -->
                    <form class="edit-form" data-id="{{ $purchase->id }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $purchase->id }}">
                        <div class="form-group">
                            <label for="status" class="form-label">Update Status:</label>
                            <select class="form-select" name="status" required>
                                <option value="pending" {{ $purchase->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="complete" {{ $purchase->status == 'complete' ? 'selected' : '' }}>Complete</option>
                                <option value="failed" {{ $purchase->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <button type="submit">Update Status</button>
                    </form>
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

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Handle status update form submission
            $('.edit-form').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                var form = $(this);
                var formData = form.serialize();
                var transactionId = form.data('id');

                $.ajax({
                    url: "{{ route('update.status') }}", // Ensure this matches the route defined in web.php
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function (response) {
                        var statusText = form.closest('.status-card').find('.status-text');
                        var newStatus = form.find('select[name="status"]').val();

                        // Update status text and color
                        statusText.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        statusText.removeClass('pending complete failed');
                        statusText.addClass(newStatus);

                        alert('Status updated successfully!');
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('An error occurred while updating the status.');
                    }
                });
            });
        });
    </script>
</body>

</html>
