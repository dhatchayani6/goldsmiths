<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $jewel->name }} Status</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* (Your existing CSS styles) */
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 jewel-status-container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('images/' . $jewelle->jewel_image) }}" alt="{{ $jewelle->name }}"
                            class="img-fluid jewel-image img-thumbnail">
                    </div>
                    <div class="col-md-6 jewel-details">
                        <h1 class="jewel-name">{{ $jewelle->name }}</h1>
                        <p class="jewel-description">{{ $jewelle->description }}</p>
                        <p class="jewel-price">Price: ${{ $jewelle->price }}</p>
                        <p class="jewel-status">Status: {{ $jewelle->status }}</p> <!-- Displaying jewel status -->
                        <a href="#" class="btn btn-success btn-purchase">Purchase</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
