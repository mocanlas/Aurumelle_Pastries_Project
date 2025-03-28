<?php

@include '../config.php';  

session_start();  

// Check if the admin is logged in
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:login.php'); 
};

// Handle user deletion if the 'delete' GET parameter is set
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM users WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');  
}

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Users Dashboard</title>

      <!-- Font Awesome CDN link for icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

      <!-- Custom admin CSS file link -->
      <link rel="stylesheet" href="../aurumelle_css/admin_style.css">

   </head>
   <body>

   <?php @include 'admin_header.php'; ?> 

   <section class="users">

      <h1 class="title">User Accounts</h1>  

      <div class="box-container">
         <?php
            // Fetch all users from the database
            $select_users = mysqli_query($conn, "SELECT * FROM users") or die('query failed');
            if(mysqli_num_rows($select_users) > 0){
               // Loop through each user record
               while($fetch_users = mysqli_fetch_assoc($select_users)){
         ?>
         <div class="box">
            <!-- Display user information -->
            <p>User ID: <span><?php echo $fetch_users['id']; ?></span></p>
            <p>Username: <span><?php echo $fetch_users['name']; ?></span></p>
            <p>Email: <span><?php echo $fetch_users['email']; ?></span></p>
            <!-- Display user type -->
            <p>User Type: <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--teal)'; }; ?>">
               <?php echo $fetch_users['user_type']; ?></span></p>
            <!-- Link to delete the user -->
            <a href="../aurumelle_admin_panel/admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete</a>
         </div>
         <?php
            }
         }
         ?>
      </div>

   </section>
   <!-- Include custom admin script -->
   <script src="../js/admin_script.js"></script>

   </body>
</html>