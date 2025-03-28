<?php

@include 'config.php';

session_start();

// Check if user is logged in, otherwise redirect to login page
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('Location: login.php');
    exit();
}

// Delete a specific item from the cart
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('Query failed');
    header('Location: cart.php');
}

// Delete all items from the cart for the logged-in user
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
    header('Location: cart.php');
}

// Update the quantity of a cart item
if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('Query failed');
    $message[] = 'Cart quantity updated!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- Font Awesome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="aurumelle_css/style.css">
</head>
<body>

    <?php @include 'header.php'; ?>

    <!-- Background section with heading -->
    <div class="wishlist-and-cart-img-background">
        <section class="heading">
            <h3>Shopping Cart</h3>
            <p><a href="home.php">Home</a> / Cart</p>
        </section>
    </div>

    <section class="shopping-cart">
        <h1 class="title">Products Added</h1>

        <div class="box-container">
            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            ?>
            <div class="box">
                <!-- Delete item from cart -->
                <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Delete this from cart?');"></a>
                
                <!-- View product details -->
                <a href="view_page.php?pid=<?php echo $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                
                <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
                <div class="name"> <?php echo $fetch_cart['name']; ?> </div>
                <div class="price">₱<?php echo $fetch_cart['price']; ?>/-</div>
                
                <!-- Update cart quantity -->
                <form action="" method="post">
                    <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
                    <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty">
                    <input type="submit" value="Update" class="option-btn" name="update_quantity">
                </form>
                
                <div class="sub-total"> Sub-total: <span>₱<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
            </div>
            <?php
                $grand_total += $sub_total;
                }
            } else {
                echo '<p class="empty">Your cart is empty</p>';
            }
            ?>
        </div>

        <!-- Delete all items button -->
        <div class="more-btn">
            <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled' ?>" onclick="return confirm('Delete all from cart?');">Delete All</a>
        </div>

        <!-- Cart total and checkout options -->
        <div class="cart-total">
            <p>Grand Total: <span>₱<?php echo $grand_total; ?>/-</span></p>
            <a href="shop.php" class="option-btn">Continue Shopping</a>
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled' ?>">Proceed to Checkout</a>
        </div>
    </section>

    <!-- Include footer section -->
    <?php @include 'footer.php'; ?>

    <!-- Custom JavaScript File -->
    <script src="js/script.js"></script>

</body>
</html>
