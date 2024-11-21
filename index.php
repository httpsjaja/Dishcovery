<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DISH-COVERY</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="mediaqueries.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Dish-covery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="container min-vh-100 d-flex align-items-center">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-4">DISH-COVERY: A social platform for recipe sharing and exploration</h1>
                <p class="lead mb-4">Welcome to Dish-covery! Whether you're an aspiring chef, a seasoned home cook, or a passionate food lover, Dish-covery is here to inspire and elevate your culinary journey.</p>
                <div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-warning me-2" onclick="window.location.href='login.php'">Login</button>
                    <button class="btn btn-outline-warning" onclick="window.location.href='signup.php'">Sign up</button>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="bg-warning bg-opacity-25 py-5">
        <div class="container">
            <h2 class="text-center mb-4">About Us</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="lead">We believe that food is not just sustenance; it's an experience that brings people together. Our mission is to connect food lovers with delicious recipes, local dining experiences, and culinary inspiration from around the globe.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="container py-5">
        <h2 class="text-center mb-5 text-success">Features</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-success">
                    <div class="card-body">
                        <h4 class="card-title text-success">Post Recipe</h4>
                        <p class="card-text">Share your culinary creations with the Dishcovery community! Our "Post Recipe" feature allows you to showcase your favorite dishes, whether they're family legacies or innovative new experiments.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-warning">
                    <div class="card-body">
                        <h4 class="card-title text-warning">Nutrition Tracker</h4>
                        <p class="card-text">Take charge of your health with our comprehensive Nutrition Tracker! Designed to help you monitor your dietary intake, this feature empowers you to make informed choices about what you eat.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-success">
                    <div class="card-body">
                        <h4 class="card-title text-success">Meal Planning</h4>
                        <p class="card-text">Simplify your culinary journey with our intuitive Meal Planning feature! Designed to help you organize your meals efficiently, this tool makes it easy to create balanced and delicious menus for any week.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="bg-success bg-opacity-10 py-5">
        <div class="container">
            <h2 class="text-center mb-5 text-success">Contact Us</h2>
            <div class="row">
                <div class="col-md-6">
                    <img src="contact-image.jpg" class="img-fluid rounded" alt="Contact Us">
                </div>
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-body">
                            <p><i class="bi bi-envelope text-success"></i> <strong>Email:</strong> <a href="mailto:dish-covery@gmail.com" class="text-success">dish-covery@gmail.com</a></p>
                            <p><i class="bi bi-telephone text-success"></i> <strong>Phone:</strong> 09668001607</p>
                            <p><i class="bi bi-geo-alt text-success"></i> <strong>Address:</strong> Lipa City, Batangas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-success text-white py-4">
        <div class="container text-center">
            <p class="mb-0">Copyright © Dish-covery. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>