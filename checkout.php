<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);

   // Safely get address fields to avoid undefined array key warnings
   $flat = isset($_POST['flat']) ? $_POST['flat'] : '';
   $street = isset($_POST['street']) ? $_POST['street'] : '';
   $city = isset($_POST['city']) ? $_POST['city'] : '';
   $country = isset($_POST['country']) ? $_POST['country'] : '';
   $pin_code = isset($_POST['pin_code']) ? $_POST['pin_code'] : '';

   $address = mysqli_real_escape_string($conn, 'flat no. '. $flat .', '. $street .', '. $city .', '. $country .' - '. $pin_code);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products = array();

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'Your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'Order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'Order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/icon.png" type="image/png">

</head>
<body>
   
<?php include 'header.php'; ?>


<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">Home</a> / Checkout </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '₱'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">Your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> Grand total : <span>₱<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>Place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Fullname</span>
            <input type="text" name="name" required placeholder="Enter your name">
         </div>
         <div class="inputBox">
            <span>Contact number</span>
            <input type="number" name="number" required placeholder="Enter your number">
         </div>
         <div class="inputBox">
            <span>Email</span>
            <input type="email" name="email" required placeholder="Enter your email">
         </div>
         <div class="inputBox">
            <span>Payment method</span>
            <select name="method">
               <option value="cash on delivery">Cash on delivery</option>
            </select>
         </div>
         <div class="inputBox">
            <span>House No.</span>
            <input type="text" min="blk" name="lot" required placeholder="e.g. blk lot.">
         </div>
         <div class="inputBox">
            <span>Barangay/Subdivision/Village</span>
            <input type="text" name="street" required placeholder="e.g. street name">
         </div>
         <div class="inputBox">
            <span>City</span>
            <input type="text" name="city" required placeholder="e.g. bacoor">
         </div>
         <div class="inputBox">
            <span>State</span>
            <input type="text" name="state" required placeholder="e.g. cavite">
         </div>
         <div class="inputBox">
            <span>Country</span>
            <input type="text" name="country" required placeholder="e.g. philippines">
         </div>
         <div class="inputBox">
            <span>Zipcode</span>
            <input type="number" min="0" name="pin_code" required placeholder="e.g. 4102">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>