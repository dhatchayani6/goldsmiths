<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOGIN PAGE</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">

                    <form method="POST" action="{{ route('login') }}" autocomplete="off" class="sign-in-form">
                        @csrf

                        <!-- Logo -->
                        <div class="logo">
                        <h4>GOLD SMITH</h4>
                        </div>

                        <!-- Heading -->
                        <div class="heading">
                            <h2>Welcome Back</h2>
                            <h6>Not registered yet?</h6>
                            <a href="#" class="toggle">Sign up</a>
                        </div>

                        <!-- Email Address -->
                        <div class="input-wrap">
                            <x-text-input id="email" class="input-field" type="email" name="email" :value="old('email')"
                                required autofocus autocomplete="username" />
                            <label for="email">Email</label>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="input-wrap">
                            <x-text-input id="password" class="input-field" type="password" name="password" required
                                autocomplete="current-password" />
                            <label for="password">Password</label>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        

                        <!-- Submit Button -->
                        <input type="submit" value="Sign In" class="sign-btn" />

                        <!-- Forgot Password Link -->
                        <p class="text">
                            Forgotten your password or login details?
                            <a href="{{ route('password.request') }}">Get help signing in</a>
                        </p>
                    </form>


                    <form method="POST" action="{{ route('register') }}" autocomplete="off" class="sign-up-form">
                        @csrf

                        <!-- Logo -->
                        <div class="logo">
                            <h4>GOLD SMITH</h4>
                        </div>

                        <!-- Heading -->
                        <div class="heading">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="{{ route('login') }}" class="toggle">Sign in</a>
                        </div>

                        <!-- Name -->
                        <div class="input-wrap">
                            <x-text-input id="name" class="input-field" type="text" name="name" :value="old('name')"
                                required autofocus autocomplete="name" />
                            <label for="name">Name</label>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="input-wrap mt-4">
                            <x-text-input id="email" class="input-field" type="email" name="email" :value="old('email')"
                                required autocomplete="username" />
                            <label for="email">Email</label>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="input-wrap mt-4">
                            <x-text-input id="password" class="input-field" type="password" name="password" required
                                autocomplete="new-password" minlength="4" />
                            <label for="password">Password</label>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="input-wrap mt-4">
                            <x-text-input id="password_confirmation" class="input-field" type="password"
                                name="password_confirmation" required autocomplete="new-password" minlength="4" />
                            <label for="password_confirmation">Confirm Password</label>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Sign Up Button -->
                        <input type="submit" value="Sign Up" class="sign-btn" />

                        <!-- Terms of Service and Privacy Policy -->
                        <p class="text mt-4">
                            By signing up, I agree to the
                            <a href="#">Terms of Services</a> and
                            <a href="#">Privacy Policy</a>
                        </p>
                    </form>
                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="../images/gold-smith.avif" class="image img-1 show" alt="Task Management" />

                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>GOLD SMITH </h2>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Javascript file -->

    <script>
        const inputs = document.querySelectorAll(".input-field");
        const toggle_btn = document.querySelectorAll(".toggle");
        const main = document.querySelector("main");
        const bullets = document.querySelectorAll(".bullets span");
        const images = document.querySelectorAll(".image");

        inputs.forEach((inp) => {
            inp.addEventListener("focus", () => {
                inp.classList.add("active");
            });
            inp.addEventListener("blur", () => {
                if (inp.value != "") return;
                inp.classList.remove("active");
            });
        });

        toggle_btn.forEach((btn) => {
            btn.addEventListener("click", () => {
                main.classList.toggle("sign-up-mode");
            });
        });

        function moveSlider() {
            let index = this.dataset.value;

            let currentImage = document.querySelector(`.img-${index}`);
            images.forEach((img) => img.classList.remove("show"));
            currentImage.classList.add("show");

            const textSlider = document.querySelector(".text-group");
            textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

            bullets.forEach((bull) => bull.classList.remove("active"));
            this.classList.add("active");
        }

        bullets.forEach((bullet) => {
            bullet.addEventListener("click", moveSlider);
        });
    </script>
</body>

</html>