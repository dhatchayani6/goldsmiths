<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goldsmith Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f0f0f5;
        }

        /* Content section styling */
        #content-wrapper {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            flex: 1; /* Allow content to grow and fill space */
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 8px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .card-icon {
            font-size: 50px; /* Adjust icon size */
            color: #007bff; /* Icon color */
            margin-top: 20px;
        }

        .card-title {
            font-weight: 500;
            color: #444;
        }

        .card-text {
            color: #777;
        }

        .footer {
            text-align: center;
            padding: 10px;
            color: #666;
            background: #f7f7f7;
            position: relative;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        .container {
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 20px;
            }
        }
        .navbar-light .navbar-nav .nav-link{
            color: black;
        }
        .navbar-light .navbar-nav .nav-link:hover{
            color: black;
        }
    </style>
</head>

<body>
    @include('smith.navabr')

    <!-- Page Content -->
    <div id="content-wrapper">
        <div class="container mt-4">
            <h1>Welcome to the Goldsmith Admin Dashboard</h1>
            <p>Manage jewelry, inventory, and orders from the cards below.</p>

            <div class="row mt-4">
                <div class="col-md-3 mb-4">
                    <div class="card" onclick="window.location='{{ route('showstorejewellery') }}'">
                        <i class="ri-add-circle-line card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Add Jewelry</h5>
                            <p class="card-text">Add new jewelry items to your inventory.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card" onclick="window.location='{{ route('jewel.queries') }}'">
                        <i class="ri-questionnaire-line card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">User Queries</h5>
                            <p class="card-text">View user queries regarding jewelry.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card" onclick="window.location='{{ route('getcustomqueries') }}'">
                        <i class="ri-pencil-line card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Custom Jewel Query</h5>
                            <p class="card-text">Handle queries for custom jewelry requests.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card" onclick="window.location='{{ route('get_purchases') }}'">
                        <i class="ri-money-dollar-circle-line card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Payment Status</h5>
                            <p class="card-text">Handle queries for payment status.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Goldsmith Admin Panel. All Rights Reserved.</p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
