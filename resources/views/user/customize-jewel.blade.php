<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Query Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .hidden {
            display: none;
        }
        .alert {
            margin-top: 20px;
        }
        /* Keyframe animations for form fields */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        /* Keyframe animation for modal */
        @keyframes slideUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .slide-up {
            animation: slideUp 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>User Query Form</h2>
        <form id="query-form" class="fade-in" method="POST" enctype="multipart/form-data">
            <!-- Hidden input to store the jewel ID and user ID -->
            <input type="hidden" name="jewel_id" value="{{ $jewelId }}">
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <!-- Image File Input -->
            <div class="form-group">
                <label for="image_file">Upload Image</label>
                <input type="file" class="form-control-file" id="image_file" name="image_url" required>
            </div>

            <!-- Query Input -->
            <div class="form-group">
                <label for="query">Query</label>
                <textarea class="form-control" id="query" name="query" rows="4" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit Query</button>
        </form>

        <!-- Modal for Success Message -->
        <div class="modal fade slide-up" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="successMessage">
                        <!-- Success message will be injected here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function () {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $("#query-form").on("submit", function (event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this); // Use FormData to handle file uploads

            $.ajax({
                url: "{{ route('store.customizedesign') }}", // Replace with your route name
                type: "POST",
                data: formData,
                processData: false, // Do not process the data
                contentType: false, // Do not set content type
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Add CSRF token to the headers
                },
                success: function (response) {
                    $("#successMessage").html('<p>' + response.message + '</p>');
                    $("#successModal").modal('show'); // Show success modal
                    $("#query-form")[0].reset(); // Reset the form
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = '<ul>';
                    $.each(errors, function (key, value) {
                        errorMessages += '<li>' + value[0] + '</li>';
                    });
                    errorMessages += '</ul>';
                    $("#successMessage").html('<p>' + errorMessages + '</p>');
                    $("#successModal").modal('show'); // Show error modal
                }
            });
        });
    });
    </script>
</body>
</html>
