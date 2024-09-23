<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
            background-color: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            margin-top: 20px;
        }

        footer p {
            margin: 0;
            font-size: 14px;
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
                                <p><strong>Amount:</strong> ${{$purchase->total_price}}</p>
                                </div>
                            <div class="status-info">
                                <h3>Status: <span class="status-text {{ strtolower($purchase->status) }}">{{ ucfirst($purchase->status) }}</span></h3>
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
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </form>
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
                        statusText.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1)); // Update the text to the new status
                        statusText.removeClass('pending complete failed'); // Remove previous status classes
                        statusText.addClass(newStatus); // Add new status class

                        alert('Status updated successfully!');
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
