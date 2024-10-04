<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goldsmith Admin Dashboard - Add New Jewelry</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f7f7f7;
        }

        .navbar {
            background: #ffcc00; /* Gold color */
        }

        #content-wrapper {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: white;
            flex: 0;
            margin-top: 20px;
        }

        h1 {
            color: #333;
        }

        .footer {
            text-align: center;
            padding: 10px;
            color: #666;
            margin-top: auto;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #ffcc00;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #e6b800;
        }

        .alert {
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control, .form-control-file {
            border-radius: 5px;
        }

        .form-row {
            margin-bottom: 20px; /* Add spacing between form rows */
            display: flex;
        }

        .form-group.col-md-6 {
            margin-right: 15px; /* Add margin to the right of each form group */
        }

        /* Remove margin from the last element in the row */
        .form-group.col-md-6:last-child {
            margin-right: 0;
        }

        .footer{
            background-color: rgba(0, 0, 0, 0.05);
        }
        .nav-link{
            color: black ;
        }
        .nav-link:hover{
            color: black ;
        }
    </style>
</head>

<body>

    @include('smith.navabr')

    <!-- Page Content -->
    <div id="content-wrapper" class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Add New Jewelry</h1>

                <!-- Success Message -->
                <div id="alertMessage" class="alert alert-success d-none" role="alert"></div>

                <!-- Jewelry Form -->
                <div class="card">
                    <div class="card-body">
                        <form id="addJewelryForm" enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewelryName">Jewelry Name</label>
                                    <input type="text" class="form-control" id="jewelryName" name="jewelryName"
                                        placeholder="Enter jewelry name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jewelryType">Jewelry Type</label>
                                    <select class="form-control" id="jewelryType" name="jewelryType" required>
                                        <option value="">Select type</option>
                                        <option value="Necklace">Necklace</option>
                                        <option value="Ring">Ring</option>
                                        <option value="Bracelet">Bracelet</option>
                                        <option value="Earrings">Earrings</option>
                                        <option value="Bangle">Bangle</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewelryWeight">Weight (in grams)</label>
                                    <input type="number" class="form-control" id="jewelryWeight" name="jewelryWeight"
                                        placeholder="Enter weight" required min="0">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jewelryPrice">Price</label>
                                    <input type="number" class="form-control" id="jewelryPrice" name="jewelryPrice"
                                        placeholder="Enter price" required min="0" step="0.01">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jewelryDescription">Description</label>
                                <textarea class="form-control" id="jewelryDescription" name="jewelryDescription"
                                    rows="3" placeholder="Enter jewelry description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="jewelryImage">Upload Image</label>
                                <input type="file" class="form-control-file" id="jewelryImage" name="jewelryImage"
                                    accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary">Add Jewelry</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Goldsmith Admin Panel. All Rights Reserved.</p>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Jewelry added successfully!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Restrict input to numeric values in the price field
            $('#jewelryPrice').on('input', function () {
                this.value = this.value.replace(/[^0-9.]/g, ''); // Allow only numbers and dots
            });

            $('#addJewelryForm').on('submit', function (e) {
                e.preventDefault(); // Prevent form from submitting the default way

                // Create a FormData object to hold the form data
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('jewel.store') }}",  // Laravel route to handle form submission
                    method: "POST",
                    data: formData,
                    contentType: false,  // For file uploads, this must be false
                    processData: false,  // For file uploads, this must be false
                    success: function (response) {
                        console.log(response); // Log the response for debugging
                        if (response.status === 'success') {
                            $('#successModal').modal('show');
                            $('#addJewelryForm')[0].reset();

                            // Reload the page after a brief delay
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000); // Adjust the delay as needed
                        } else {
                            alert(response.message);
                            window.location.reload();
                        }
                    },
                    error: function (response) {
                        alert('Error accepting query.');
                        var errors = response.responseJSON.errors;
                        var errorMessages = 'Errors:\n'; // Create a string for all error messages
                        $.each(errors, function (key, value) {
                            errorMessages += value[0] + '\n'; // Append each error message
                        });
                        alert(errorMessages); // Show all error messages in an alert
                    }
                });
            });
        });
    </script>

</body>

</html>
