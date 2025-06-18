<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

// PAGINATION LOGIC
$orders_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $orders_per_page;

// Get total orders count
$total_orders_query = mysqli_query($conn, "SELECT COUNT(*) FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
$total_orders_row = mysqli_fetch_row($total_orders_query);
$total_orders = $total_orders_row[0];
$total_pages = ceil($total_orders / $orders_per_page);

// Fetch paginated orders
$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY id DESC LIMIT $start_from, $orders_per_page") or die('query failed');

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/icon.png" type="image/png">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>your orders</h3>
   <p> <a href="home.php">Home</a> / Orders </p>
</div>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="table-container">
      <table class="cart-table">
         <thead>
            <tr>
               <th>Placed On</th>
               <th>Name</th>
               <th>Number</th>
               <th>Email</th>
               <th>Address</th>
               <th>Payment Method</th>
               <th>Your Orders</th>
               <th>Total Price</th>
               <th>Payment Status</th>
            </tr>
         </thead>
         <tbody>
         <?php
            if(mysqli_num_rows($order_query) > 0){
               while($fetch_orders = mysqli_fetch_assoc($order_query)){
         ?>
            <tr>
               <td><?php echo $fetch_orders['placed_on']; ?></td>
               <td><?php echo $fetch_orders['name']; ?></td>
               <td><?php echo $fetch_orders['number']; ?></td>
               <td><?php echo $fetch_orders['email']; ?></td>
               <td><?php echo $fetch_orders['address']; ?></td>
               <td><?php echo $fetch_orders['method']; ?></td>
               <td><?php echo $fetch_orders['total_products']; ?></td>
               <td>₱<?php echo $fetch_orders['total_price']; ?></td>
               <td style="color:<?php echo ($fetch_orders['payment_status'] == 'pending') ? 'red' : 'green'; ?>">
                  <?php echo $fetch_orders['payment_status']; ?>
               </td>
            </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="9" class="empty">no orders placed yet!</td></tr>';
            }
         ?>
         </tbody>
      </table>
   </div>
   <?php if($total_pages > 1): ?>
   <div class="pagination">
      <?php for($i = 1; $i <= $total_pages; $i++): ?>
         <?php if($i == $page): ?>
            <span class="btn"><?php echo $i; ?></span>
         <?php else: ?>
            <a href="?page=<?php echo $i; ?>" class="btn"><?php echo $i; ?></a>
         <?php endif; ?>
      <?php endfor; ?>
   </div>
   <?php endif; ?>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>