<?php

@include 'config.php';  

session_start(); 

$user_id = $_SESSION['user_id'];  

// If the user is not logged in, redirect them to the login page
if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- Font Awesome CDN link for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file for styling -->
   <link rel="stylesheet" href="aurumelle_css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?> 

<div class="orders-img-background">
    <section class="heading">
        <h3>Your Orders</h3>
        <p><a href="home.php">Home</a> / Orders</p>  
    </section>
</div>

<section class="placed-orders">

    <h1 class="title">Placed Orders</h1>  

    <div class="box-container">

    <?php
        // Query the database to get the orders placed by the current user
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
        
        // Check if there are any orders
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
    ?>
    <div class="box">
        <!-- Display order details -->
        <p>Placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
        <p>Name: <span><?php echo $fetch_orders['name']; ?></span></p>
        <p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
        <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
        <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
        <p>Payment Method: <span><?php echo $fetch_orders['method']; ?></span></p>
        <p>Your Orders: <span><?php echo $fetch_orders['total_products']; ?></span></p>
        <p>Total Price: <span>₱<?php echo $fetch_orders['total_price']; ?>/-</span></p>
        
        <!-- Payment status -->
        <p>Payment Status: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){echo 'tomato'; }else{echo 'green';} ?>">
            <?php echo $fetch_orders['payment_status']; ?>
        </span></p>
    </div>
    <?php
        }
    } else {
        echo '<p class="empty">No orders placed yet!</p>';
    }
    ?>
    </div>

</section>
<!-- Include footer section -->
<?php @include 'footer.php'; ?>  
<!-- Custom JavaScript File -->
<script src="js/script.js"></script>  

</body>
</html>
