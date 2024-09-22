<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customized Jewelry</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #3498db;
            margin-bottom: 20px;
        }

        .jewelry-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .jewelry-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            width: 250px;
            transition: transform 0.2s;
        }

        .jewelry-card:hover {
            transform: scale(1.05);
        }

        .jewelry-image {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .jewelry-details {
            margin-top: 10px;
        }

        .jewelry-details p {
            margin: 5px 0;
        }

        .price {
            font-weight: bold;
            color: #e74c3c;
        }
    </style>
</head>

<body>
    @include('smith.navabr')

    <h1>Customized Jewelry Collection</h1>
    <div class="container">
        <div class="jewelry-container row">
            @foreach($customJewelry as $jewelry)
                <div class="col-md-4 col-sm-6">
                    <div class="jewelry-card">
                        <img src="{{ asset('images/' . $jewelry->image) }}" alt="{{ $jewelry->name }}" class="jewelry-image">
                        <div class="jewelry-details">
                            <h3>{{ $jewelry->name }}</h3>
                            <p>{{ $jewelry->description }}</p>
                            <p class="price">${{ number_format($jewelry->price, 2) }}</p>
                            <button class="btn btn-primary">View Details</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
