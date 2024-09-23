<!-- Bootstrap Navbar with Custom Styling -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <a class="navbar-brand" href="#">Gold Smith</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('login')}}">Sign in</a>
      </li>
    </ul>
  </div>
</nav>

<!-- Custom CSS -->
<style>
  /* Navbar Custom Background and Text */
  .navbar-custom {
    background-color: #ffcc00;
    padding: 10px 20px;
  }

  .navbar-custom .navbar-brand {
    color: #ffff;
    font-weight: bold;
    font-size: 24px;
    font-family: 'Poppins', sans-serif;
  }

  .navbar-custom .nav-link {
    color: #ffffff;
    font-size: 18px;
    margin-right: 15px;
    transition: color 0.3s ease;
  }

  .navbar-custom .nav-link:hover {
    color: #000000;
    text-decoration: underline;
  }

  /* Mobile View Styling */
  .navbar-toggler-icon {
    background-color: #ffffff;
  }

  

  /* Custom Font and Link Hover Effect */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
</style>
