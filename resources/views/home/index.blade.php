<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold Smith</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Style the background section */
        .bg-image-section {
            background-image: url('images/background-gold.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
        }

        .bg-image-section .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background: rgba(0, 0, 0, 0.6); */
            background-image: url(images/goldsmith-bg.avif);
            background-position: center;
            background-size: cover;
        }

        .bg-image-section .container {
            position: relative;
            z-index: 1;
        }

        h1,
        p {
            animation: fadeInUp 1.2s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Style the cards in the carousel */
        .slider-box .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .slider-box .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .slider-box .profile-pic img {
            width: 100%;
            border-radius: 15px;
        }

        /* Add some padding and background color */
        .card {
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }

        .owl-carousel .owl-nav button.owl-prev,
        .owl-carousel .owl-nav button.owl-next {
            background-color: #f8d64e;
            border-radius: 50%;
            color: #fff;
        }

        .owl-carousel .owl-stage-outer {
            position: relative;
            overflow: hidden;
            height: 619px;
            padding-top: 5rem;
        }
        /* Style for the background video */
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
    background: rgba(0, 0, 0, 0.4); /* Optional: dark overlay on top of the video */
    z-index: 0;
}

.bg-video-section .container {
    position: relative;
    z-index: 1;
    top: 34%;
}

    </style>
</head>

<body>
    @include('home.navabr')

    <!-- Hero Section -->
    <!-- Hero Section with Background Video -->
<section class="bg-video-section position-relative">
    <video autoplay muted loop playsinline class="bg-video">
        <source src="images/bannerviedeo.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="overlay"></div>
    <!-- Content -->
    <div class="container text-center text-white position-relative">
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
                    <div class="card">
                        <div class="profile-pic">
                            <img src="images/gold2.avif" alt="Gold Image 1">
                        </div>
                    </div>
                    <!-- Carousel Card 2 -->
                    <div class="card">
                        <div class="profile-pic">
                            <img src="images/gold2.avif" alt="Gold Image 2">
                        </div>
                    </div>
                    <!-- Carousel Card 3 -->
                    <div class="card">
                        <div class="profile-pic">
                            <img src="images/gold2.avif" alt="Gold Image 3">
                        </div>
                    </div>
                    <!-- Carousel Card 4 -->
                    <div class="card">
                        <div class="profile-pic">
                            <img src="images/gold2.avif" alt="Gold Image 4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('home.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel({
                loop: true,
                nav: true,
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