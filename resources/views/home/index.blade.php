<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold Smith</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            background-color: #ffffff;
            color: #333;
        }

        .bg-video-section {
            position: relative;
            height: 600px;
            overflow: hidden;
        }

        .bg-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .bg-video-section .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .bg-video-section .container {
            position: relative;
            z-index: 1;
            top: 30%;
            text-align: center;
            color: #ffcc00; /* Gold color */
        }

        .bg-video-section h1 {
            font-size: 4rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        .bg-video-section p {
            font-size: 1.5rem;
            margin-top: 1rem;
        }

        .features-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }

        .feature-card {
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
        }

        .footer a {
            color: #ffcc00;
        }

        /* .footer a:hover {
            text-decoration: underline;
        } */

        .owl-carousel .owl-stage-outer {
            width: 100%;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .bg-video-section h1 {
                font-size: 2.5rem;
            }

            .bg-video-section p {
                font-size: 1.2rem;
            }
        }

        /* Navbar Custom Background and Text */
        .navbar-custom {
            background-color: #ffcc00;
            padding: 10px 20px;
        }

        .navbar-custom .navbar-brand {
            color: #000000;
            /* font-weight: bold; */
            font-size: 24px;
            font-family: 'Poppins', csans-serif;
        }

        .navbar-custom .nav-link {
            color: #000000;
            font-size: 24px;
            margin-right: 15px;
            transition: color 0.3s ease;
        }

        .navbar-custom .nav-link:hover {
            color: #000000;
            /* text-decoration: underline; */
        }

        /* Mobile View Styling */
        .navbar-toggler-icon {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    @include('home.navabr')

    <!-- Hero Section -->
    <section class="bg-video-section position-relative">
        <video autoplay muted loop playsinline class="bg-video">
            <source src="images/bannerviedeo.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        <div class="overlay"></div>
        <div class="container">
            <h1 class="display-1">Experience the Magic of Gold</h1>
            <p class="lead">Transform your vision into gold—where efficiency meets excellence.</p>
        </div>
    </section>

    <!-- Carousel Section -->
    <section class="my-5">
        <div class="container">
            <h1 class="text-center mb-5">Have a Look at Our Collection</h1>
            <div class="slider-box owl-carousel">
                <!-- Carousel Item 1 -->
                <div class="item">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1596942499930-c980d61ddd70?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                             alt="A brunette woman wearing pretty gold jewellery." class="card-img-top">
                    </div>
                </div>
                <!-- Carousel Item 2 -->
                <div class="item">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1596944946054-85fae2e50d5e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=634&q=80"
                             alt="A blond woman wearing golden circle earrings." class="card-img-top">
                    </div>
                </div>
                <!-- Carousel Item 3 -->
                <div class="item">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1596944924616-7b38e7cfac36?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                             alt="Arms adorned with multiple gold rings and a bracelet." class="card-img-top">
                    </div>
                </div>
                <!-- Carousel Item 4 -->
                <div class="item">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1616413552922-aa3906103397?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                             alt="A woman wearing heart-shaped golden earrings." class="card-img-top">
                    </div>
                </div>
                <!-- Carousel Item 5 -->
                <div class="item">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1612529328850-598a0e3a3e31?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=634&q=80"
                             alt="A woman wearing golden circle earrings with pearls." class="card-img-top">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Goldsmithing Section -->
    <section class="features-section text-center">
        <div class="container">
            <h2 class="mb-4">The Art of Goldsmithing in Today’s World</h2>
            <p class="lead mb-5">In an age where craftsmanship meets technology, goldsmithing has evolved into an exquisite blend of traditional skills and modern innovation.</p>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card feature-card">
                        <div class="card-body">
                            <h5 class="card-title">Craftsmanship</h5>
                            <p class="card-text">Goldsmiths today merge age-old techniques with contemporary designs, creating unique pieces that tell a story.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card feature-card">
                        <div class="card-body">
                            <h5 class="card-title">Sustainability</h5>
                            <p class="card-text">Modern goldsmithing emphasizes ethical sourcing and sustainable practices to reduce environmental impact.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card feature-card">
                        <div class="card-body">
                            <h5 class="card-title">Innovation</h5>
                            <p class="card-text">With the advent of new technologies, goldsmiths are now able to experiment with innovative designs and techniques.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('home.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                margin: 20,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        });
    </script>
</body>

</html>
