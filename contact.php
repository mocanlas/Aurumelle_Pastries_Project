<?php

@include 'config.php';

session_start();

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// If the user is not logged in, redirect to the login page
if (!isset($user_id)) {
    header('location:login.php');
}

// If the form is submitted
if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    // Check if the same message has already been sent
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('Query failed');

    // If the message has already been sent, display a message
    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'Message already sent!';
    } else {
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('Query failed');
        $message[] = 'Message sent successfully!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>

   <!-- Font Awesome CDN for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS for styling -->
   <link rel="stylesheet" href="aurumelle_css/style.css">
</head>
<body>
   
<?php @include 'header.php'; ?>

<!-- Background image for contact section -->
<div class="contact-img-background">
    <section class="heading">
        <h3>Contact Us</h3>
        <p> <a href="home.php">Home</a> / Contact </p>
    </section>
</div>

<!-- Contact form section -->
<section class="contact">

    <form action="" method="POST">
        <h3>Send us a message!</h3>
        <input type="text" name="name" placeholder="Enter your name" class="box" required>
        <input type="email" name="email" placeholder="Enter your email" class="box" required>
        <input type="number" name="number" placeholder="Enter your number" class="box" required>
        <textarea name="message" class="box" placeholder="Enter your message" required cols="30" rows="10"></textarea>
        <input type="submit" value="Send Message" name="send" class="btn">
    </form>

</section>

<!-- Include the footer -->
<?php @include 'footer.php'; ?>
<!-- Custom JavaScript File -->
<script src="js/script.js"></script>

</body>
</html>
