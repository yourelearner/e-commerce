<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'Cart quantity updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/icon.png" type="image/png">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>shopping cart</h3>
   <p> <a href="home.php">Home</a> / Cart </p>
</div>

<section class="shopping-cart">

   <h1 class="title">Products added</h1>

   <?php
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
   ?>
   <div class="cart-table-container">
   <table class="cart-table">
      <thead>
         <tr>
            <th>Remove</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Sub Total</th>
         </tr>
      </thead>
      <tbody>
      <?php
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
      ?>
         <tr>
            <td>
               <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
            </td>
            <td>
               <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" style="width:60px; height:60px; object-fit:cover; border-radius:5px;">
            </td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>₱<?php echo $fetch_cart['price']; ?>/-</td>
            <td>
               <form action="" method="post" style="display:inline;">
                  <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>" style="width:60px;">
                  <input type="submit" name="update_cart" value="update" class="option-btn" style="padding:0.5rem 1rem; font-size:1.2rem;">
               </form>
            </td>
            <td>
               ₱<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-
            </td>
         </tr>
      <?php
         $grand_total += $sub_total;
         }
      ?>
      </tbody>
   </table>
   </div>
   <?php
      }else{
         echo '<p class="empty">Your cart is empty</p>';
      }
   ?>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Delete all from cart?');">delete all</a>
   </div>

   <div class="cart-total">
      <p>Grand total : <span>₱<?php echo $grand_total; ?>/-</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">continue shopping</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
      </div>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>