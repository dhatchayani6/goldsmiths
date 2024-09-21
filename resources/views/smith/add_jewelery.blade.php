<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goldsmith Admin Dashboard - Add New Jewelry</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
            margin: 0;
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            flex: 1;
        }

        h1 {
            color: #333;
        }

        .footer {
            text-align: center;
            padding: 10px;
            color: #666;
        }
    </style> 
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Goldsmith Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                @if (Auth::check())
                    <li>
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-primary">LOGOUT ({{ Auth::user()->name }})</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="content-wrapper">
        <div class="container mt-4">
            <h1 class="mb-4">Add New Jewelry</h1>

            <!-- Jewelry Form -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <form method="POST" action="{{ route('jewel.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

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
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewelryWeight">Weight (in grams)</label>
                                    <input type="number" class="form-control" id="jewelryWeight" name="jewelryWeight"
                                        placeholder="Enter weight" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jewelryPrice">Price</label>
                                    <input type="number" class="form-control" id="jewelryPrice" name="jewelryPrice"
                                        placeholder="Enter price" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jewelryDescription">Description</label>
                                <textarea class="form-control" id="jewelryDescription" name="jewelryDescription" rows="3"
                                    placeholder="Enter jewelry description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="jewelryImage">Upload Image</label>
                                <input type="file" class="form-control-file" id="jewelryImage" name="jewelryImage" accept="image/*">
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
