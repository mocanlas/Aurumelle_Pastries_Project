<?php
// Check if there are any messages in the session
if(isset($message)){
   // Loop through each message and display it
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>  <!-- Display the message -->
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>  <!-- Close button to remove the message -->
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">

      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <!-- Navigation menu -->
      <nav class="navbar">
         <a href="admin_page.php">Home</a>  
         <a href="admin_products.php">Products</a> 
         <a href="admin_orders.php">Orders</a>  
         <a href="admin_users.php">Users</a> 
         <a href="admin_contacts.php">Messages</a>  
      </nav>

      <!-- Icons section -->
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>  
         <div id="user-btn" class="fas fa-user"></div>  
      </div>

      <!-- Account box section -->
      <div class="account-box">
         <p>username : <span><?php echo $_SESSION['admin_name']; ?></span></p>  
         <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>  
         <a href="../logout.php" class="delete-btn">logout</a> 
         <div>new <a href="../login.php">login</a> | <a href="../register.php">register</a> </div>  
      </div>

   </div>

</header>
