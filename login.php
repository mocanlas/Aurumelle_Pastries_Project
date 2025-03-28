<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);
    
        if ($pass == $row['password']) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('Location: aurumelle_admin_panel/admin_page.php');
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('Location: home.php');
            }
        } else {
            $message[] = 'Incorrect email or password!';
        }
    } else {
        $message[] = 'No user found!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="aurumelle_css/login-and-register-style.css">
</head>
<body>

<div class="container">
    <div class="login-section">
        <div class="form-box">
            <h3>Welcome Back!</h3>
            <?php if (isset($message)) { foreach ($message as $msg) { echo '<p class="message">'.$msg.'</p>'; } } ?>
            <form action="" method="post">
                <div class="input-box">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input type="password" name="pass" required>
                    <label>Password</label>
                </div>
                <button class="btn" name="submit">Login</button>
                <div class="account-login">
                    <label>Don't have an account? <a href="register.php">Register now</a></label>
                </div>
            </form>
        </div>
    </div>
    
    <div class="items">
        <div class="overlay"></div>
        <div class="content">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="images/slide-5.jpg" alt="Slide 1"></div>
                    <div class="swiper-slide"><img src="images/slide-6.jpg" alt="Slide 2"></div>
                    <div class="swiper-slide"><img src="images/slide-7.jpg" alt="Slide 3"></div>
                    <div class="swiper-slide"><img src="images/slide-8.jpg" alt="Slide 4"></div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>

<!-- Swiper.js Script -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" }
        });
    });
</script>
</body>
</html>
