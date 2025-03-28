<?php

@include 'config.php';

session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <!-- Font Awesome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="aurumelle_css/style.css">
</head>
<body>

    <?php @include 'header.php'; ?>

    <!-- Background section with heading -->
    <div class="about-img-background">
        <section class="heading">
            <h3>About Us</h3>
            <p><a href="home.php">Home</a> / About</p>
        </section>
    </div>

    <!-- About section starts here -->
    <section class="about">
        
        <!-- First content block -->
        <div class="flex">
            <div class="image">
                <img src="images/about-img1.jpg" alt="About Image 1">
            </div>
            <div class="content">
                <h3>Why Choose Us?</h3>
                <p>At Aurumelle Pastries, we are more than just a bakery—we are a team of passionate bakers dedicated to crafting exquisite, handcrafted pastries that bring joy in every bite. We blend classic baking techniques with modern artistry to create visually stunning and delicious desserts.</p>
                <a href="shop.php" class="btn">Shop Now</a>
            </div>
        </div>

        <!-- Second content block -->
        <div class="flex">
            <div class="content">
                <h3>What We Provide</h3>
                <p>We offer a variety of pastries and desserts for every occasion:</p>
                <ul>
                    <li>🍰 <strong>Handmade Cakes</strong> – Perfect for birthdays, weddings, and special events.</li>
                    <li>🥐 <strong>Flaky Pastries</strong> – Fresh croissants, danishes, and more baked daily.</li>
                    <li>🍪 <strong>Deluxe Cookies</strong> – Soft, chewy, and packed with flavor.</li>
                    <li>🍮 <strong>Exquisite Desserts</strong> – Tarts, mousses, and more, made with precision.</li>
                    <li>🎁 <strong>Personalized Orders & Gift Packages</strong> – Thoughtful and elegant sweet treats.</li>
                </ul>
                <a href="contact.php" class="btn">Contact Us</a>
            </div>
            <div class="image">
                <img src="images/about-img2.jpg" alt="About Image 2">
            </div>
        </div>

        <!-- Third content block -->
        <div class="flex">
            <div class="image">
                <img src="images/about-img3.jpg" alt="About Image 3">
            </div>
            <div class="content">
                <h3>Who We Are</h3>
                <p>At Aurumelle Pastries, we pride ourselves on delivering excellence in every bite:</p>
                <ul>
                    <li>✨ <strong>Premium Quality</strong> – We use only the finest ingredients for rich flavors.</li>
                    <li>🥇 <strong>Handcrafted with Love</strong> – Each pastry is made from scratch with care.</li>
                    <li>🎂 <strong>Customized for You</strong> – Personalized cakes and pastries tailored to your taste.</li>
                    <li>💛 <strong>Exceptional Service</strong> – We create more than desserts; we create experiences.</li>
                </ul>
                <p>Ready to indulge? Visit us or place an order to experience the magic of Aurumelle Pastries!</p>
            </div>
        </div>
    </section>

    <!-- Include footer section -->
    <?php @include 'footer.php'; ?>

    <!-- Custom JavaScript File -->
    <script src="js/script.js"></script>

</body>
</html>