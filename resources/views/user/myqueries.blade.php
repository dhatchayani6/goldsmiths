<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Custom Queries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Your existing styles here */
        .jewel-image {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>User Queries</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Query</th>
                    <th>User ID</th>
                    <th>Jewel Image</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($showcustomizationqueries as $customizequeries)
                    <tr>
                        <td>{{ $customizequeries->id }}</td>
                        <td>{{ $customizequeries->query }}</td>
                        <td>{{ $customizequeries->user_id }}</td>
                        <td>
                            <img src="{{ $customizequeries->image_url }}" alt="Image" class="jewel-image">
                        </td>
                        <td>{{ $customizequeries->status }}</td>
                        <td>{{ $customizequeries->total_price }}</td>
                        <td>
                            <button class="btn btn-success purchase-btn" data-id="{{ $customizequeries->id }}"
                                data-jewel-id="{{ $customizequeries->jewel->id }}"
                                data-jewel-name="{{ $customizequeries->jewel->name }}"
                                data-jewel-price="{{ $customizequeries->total_price }}">
                                Payment
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Purchase Modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseModalLabel">Purchase Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="purchase-form" method="POST" action="{{ route('purchase.store') }}">
                        @csrf
                        <div class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewel_name">Jewel Name</label>
                                    <input type="text" class="form-control" id="jewel_name" name="jewel_name" readonly>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="jewel_id" id="jewel_id">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="amount" id="amount" required>

                        <div class="form-row mb-4">
                            <div class="form-group col-md-6">
                                <label for="total_price">Total Price</label>
                                <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="customer_name">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="zip_code">Zip Code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>

                        <!-- Payment Method -->
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="razorpay">Razorpay</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>

                        <!-- Card Payment Fields -->
                        <div id="card-fields" class="hidden" style="display: none;">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="card_name">Cardholder Name</label>
                                    <input type="text" class="form-control" id="card_name" name="card_name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="card_number">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cvv">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv">
                                </div>
                            </div>
                        </div>

                        <!-- Razorpay Payment Fields -->
                        <div id="razorpay-fields" class="hidden" style="display: none;">
                            <div class="form-group">
                                <label for="razorpay_payment_id">Razorpay Payment ID</label>
                                <input type="text" class="form-control" id="razorpay_payment_id" name="razorpay_payment_id">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.purchase-btn').on('click', function () {
                const jewelId = $(this).data('jewel-id');
                const jewelName = $(this).data('jewel-name');
                const jewelPrice = parseFloat($(this).data('jewel-price'));

                $('#jewel_id').val(jewelId);
                $('#jewel_name').val(jewelName);
                $('#amount').val(jewelPrice);
                $('#total_price').val(jewelPrice.toFixed(2)); // Set initial total price
                $('#purchaseModal').modal('show');
            });

            $('#payment_method').on('change', function () {
                const method = $(this).val();
                $('#card-fields').hide();
                $('#razorpay-fields').hide();

                if (method === 'card') {
                    $('#card-fields').show();
                } else if (method === 'razorpay') {
                    $('#razorpay-fields').show();
                }
            });

            // Handle form submission
            $('#purchase-form').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (response) {
                        alert(response.message); // Display success message
                        $('#purchaseModal').modal('hide'); // Close modal
                        $('#purchase-form')[0].reset(); // Reset the form
                    },
                    error: function (response) {
                        const errors = response.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:\n';
                        for (let field in errors) {
                            errorMessage += `${errors[field][0]}\n`; // Display the first error for each field
                        }
                        alert(errorMessage); // Display error messages
                    }
                });
            });
        });
    </script>
</body>

</html>
