<?php

@include '../config.php'; 


session_start(); 

// Get the admin ID from the session
$admin_id = $_SESSION['admin_id'];

// Check if the admin is logged in
if(!isset($admin_id)){
   header('location:login.php');
}

// Handle deleting a message from the contact form
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];  
    mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed'); 
    header('location:admin_contacts.php');  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- Font Awesome CDN link for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

   <!-- Custom CSS file for the admin dashboard -->
   <link rel="stylesheet" href="../aurumelle_css/admin_style.css">

</head>
<body>

<?php @include 'admin_header.php'; ?> 

<section class="messages">
    <h1 class="title">Messages</h1>

    <div class="box-container">

        <?php
        // Retrieve all the messages from the database
        $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
        
        // Check if there are any messages
        if(mysqli_num_rows($select_message) > 0){
            while($fetch_message = mysqli_fetch_assoc($select_message)){
        ?>
        <!-- Displays each of the message -->
        <div class="box">
            <p>user id : <span><?php echo $fetch_message['user_id']; ?></span> </p>  
            <p>name : <span><?php echo $fetch_message['name']; ?></span> </p>  
            <p>number : <span><?php echo $fetch_message['number']; ?></span> </p>  
            <p>email : <span><?php echo $fetch_message['email']; ?></span> </p>  
            <p>message : <span><?php echo $fetch_message['message']; ?></span> </p> 
            <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>  <!-- Delete button with confirmation prompt -->
        </div>
        <?php
            }
        }else{
           
            echo '<p class="empty">you have no messages!</p>';
        }
        ?>
    </div>

</section>
<!-- Include custom admin script -->
<script src="../js/admin_script.js"></script> 

</body>
</html>