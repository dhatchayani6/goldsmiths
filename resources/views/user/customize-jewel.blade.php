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

        body{
            /* background-image: url('../images/background.avif'); */
        }
        .hidden {
            display: none;
        }
        .alert {
            margin-top: 20px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes slideUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .slide-up {
            animation: slideUp 0.5s ease-out;
        }
        footer {
            background-color: #f7f7f7 !important;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .navbar-light .navbar-nav .nav-link {
            color: black;
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: black;
        }
    </style>
</head>
<body>
@include('user.navbar')

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>User Query Form</h2>
        </div>
        <div class="card-body">
            <form id="query-form" class="fade-in" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="jewel_id" value="{{ $jewelId }}">
                @if(auth()->check())
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                @endif

                <div class="form-group">
                    <label for="image_file">Upload Image</label>
                    <input type="file" class="form-control-file" id="image_file" name="image_url" required>
                </div>

                <div class="form-group">
                    <label for="query">Query</label>
                    <textarea class="form-control" id="query" name="query" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Query</button>
            </form>
        </div>
    </div>

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

<!-- Footer -->
@include('home.footer')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $("#query-form").on("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('store.customizedesign') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $("#successMessage").html('<p>' + response.message + '</p>');
                $("#successModal").modal('show');
                $("#query-form")[0].reset();
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMessages = '<ul>';
                $.each(errors, function (key, value) {
                    errorMessages += '<li>' + value[0] + '</li>';
                });
                errorMessages += '</ul>';
                $("#successMessage").html('<p>' + errorMessages + '</p>');
                $("#successModal").modal('show');
            }
        });
    });
});
</script>
</body>
</html>
