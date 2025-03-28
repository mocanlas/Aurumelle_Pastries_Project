<?php

@include 'config.php';  

// Check if the form is submitted
if(isset($_POST['submit'])){

   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);

   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $email = mysqli_real_escape_string($conn, $filter_email);

   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass)); 

   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_pass));  

   // Check if the email already exists in the database
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   // If the user already exists, show an error message
   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'User already exists!';
   }else{
      // If passwords do not match, show an error message
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
         $message[] = 'Registered successfully!';
         header('location:login.php');  
         exit();
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Font Awesome CDN for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Swiper.js CSS for image slider -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

   <!-- Custom CSS for styling login and registration pages -->
   <link rel="stylesheet" href="aurumelle_css/login-and-register-style.css">
</head>
<body>

<?php
// Display messages if any errors or success messages exist
if(isset($message)){
   foreach($message as $msg){
      echo '<div class="message"><span>'.$msg.'</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
   }
}
?>

<div class="container">
    <!-- Registration Form -->
    <div class="login-section">
        <div class="form-box">
            <h3>Welcome.</h3>
            <form action="" method="post">
                <div class="input-box">
                    <input type="text" name="name" required> 
                    <label>Name</label>
                </div>
                <div class="input-box">
                    <input type="email" name="email" required>  
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input type="password" name="pass" required>  
                    <label>Password</label>
                </div>
                <div class="input-box">
                    <input type="password" name="cpass" required> 
                    <label>Confirm Password</label>
                </div>
                <button type="submit" name="submit" class="btn">Register</button>  
                <div class="term-condition">
                    <label><input type="checkbox" required> Yes, I agree with the terms and conditions</label>
                </div>
                <div class="account-login">
                    <label>Already have an account? <a href="login.php">Login</a></label>  
                </div>
            </form>
        </div>
    </div>
    
    <!-- Swiper Image Slider -->
    <div class="items">
        <div class="content">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="images/slide-1.jpg" alt="Slide 1">
                    </div>
                    <div class="swiper-slide">
                        <img src="images/slide-2.jpg" alt="Slide 2">
                    </div>
                    <div class="swiper-slide">
                        <img src="images/slide-3.jpg" alt="Slide 3">
                    </div>
                    <div class="swiper-slide">
                        <img src="images/slide-4.jpg" alt="Slide 4">
                    </div>
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
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    });
</script>

</body>
</html>
