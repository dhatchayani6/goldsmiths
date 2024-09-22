<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold Smith</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <style>
        /* Style the background section */
        .bg-video-section {
            position: relative;
            height: 100vh;
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
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }

        .bg-video-section .container {
            position: relative;
            z-index: 1;
            top: 34%;
            text-align: center;
            color: white;
        }

        .features-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }

        .feature-card {
            border: none;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }

        .footer a {
            color: white;
        }

        .footer a:hover {
            text-decoration: underline;

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
            <div class="row">
                <div class="slider-box owl-carousel">
                    <!-- Carousel Card 1 -->
                    <div class="item">
                        <div class="card">
                            <img src="images/gold2.avif" class="card-img-top" alt="Gold Image 1">
                        </div>
                    </div>
                    <!-- Carousel Card 2 -->
                    <div class="item">
                        <div class="card">
                            <img src="images/gold2.avif" class="card-img-top" alt="Gold Image 2">
                        </div>
                    </div>
                    <!-- Carousel Card 3 -->
                    <div class="item">
                        <div class="card">
                            <img src="images/gold2.avif" class="card-img-top" alt="Gold Image 3">
                        </div>
                    </div>
                    <!-- Carousel Card 4 -->
                    <div class="item">
                        <div class="card">
                            <img src="images/gold2.avif" class="card-img-top" alt="Gold Image 4">
                        </div>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel({
                loop: true,
                nav: true,
                dots: true,
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
