<?php

@include '../config.php'; 

session_start(); 

// Check if the admin is logged in
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:login.php');  
};

if(isset($_POST['add_product'])){

    // Sanitize user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    
    // Handle image upload
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;

    // Check if the product name already exists in the database
    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');
 
    if(mysqli_num_rows($select_product_name) > 0){
       $message[] = 'Product name already exists!';  
    }else{
       // Insert new product into the database
       $insert_product = mysqli_query($conn, "INSERT INTO `products`(name, details, price, image) VALUES('$name', '$details', '$price', '$image')") or die('query failed');
 
       if($insert_product){
          if($image_size > 2000000){
             $message[] = 'Image size is too large!';  
          }else{
             move_uploaded_file($image_tmp_name, $image_folder);  
             $message[] = 'Product added successfully!'; 
            }
        }
    }
}

if(isset($_GET['delete'])){
    // Delete product and associated data from the database
    $delete_id = $_GET['delete'];
    
    // Fetch the image file name of the product to delete
    $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
    
    // Remove the image file from the server
    unlink('../uploaded_img/'.$fetch_delete_image['image']);
    
    // Delete product and related data from the database
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
    header('location:admin_products.php');  
}

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Products</title>

      <!-- Font Awesome CDN link for icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

      <!-- Custom admin CSS file link -->
      <link rel="stylesheet" href="../aurumelle_css/admin_style.css">

   </head>
   <body>

   <?php @include 'admin_header.php'; ?>  

   <section class="add-products">
      <!-- Form to add a new product -->
      <form action="" method="POST" enctype="multipart/form-data">
         <h3>Add New Product</h3>
         <input type="text" class="box" required placeholder="Enter product name" name="name">
         <input type="number" min="0" class="box" required placeholder="Enter product price" name="price">
         <textarea name="details" class="box" required placeholder="Enter product details" cols="30" rows="10"></textarea>
         <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
         <input type="submit" value="Add Product" name="add_product" class="btn">
      </form>
   </section>

   <section class="show-products">
      <h3 class="title">Added Product/s</h3>
      <div class="box-container">
         <?php
            // Fetch all products from the database
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if(mysqli_num_rows($select_products) > 0){
               while($fetch_products = mysqli_fetch_assoc($select_products)){
         ?>
         <div class="box">
            <div class="price">₱<?php echo $fetch_products['price']; ?>/-</div>
            <img class="image" src="../uploaded_img/<?php echo $fetch_products['image']; ?>" alt="Product Image">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="details"><?php echo $fetch_products['details']; ?></div>
            <a href="../aurumelle_admin_panel/admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
            <a href="../aurumelle_admin_panel/admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
         </div>
         <?php
            }
         }else{
            echo '<p class="empty">No products added yet!</p>';
         }
         ?>
      </div>
   </section>
   <!-- Include custom admin script -->
   <script src="../js/admin_script.js"></script>  

   </body>
</html>
