<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'Payment status has been updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

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

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
    <link rel="icon" href="images/icon.png" type="image/png">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">placed orders</h1>

   <?php
   // PAGINATION LOGIC
   $orders_per_page = 5; // Change this value as needed
   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
   $start_from = ($page - 1) * $orders_per_page;

   // Get total orders count
   $total_orders_query = mysqli_query($conn, "SELECT COUNT(*) FROM `orders`") or die('query failed');
   $total_orders_row = mysqli_fetch_row($total_orders_query);
   $total_orders = $total_orders_row[0];
   $total_pages = ceil($total_orders / $orders_per_page);

   // Fetch paginated orders
   $select_orders = mysqli_query($conn, "SELECT * FROM `orders` ORDER BY id DESC LIMIT $start_from, $orders_per_page") or die('query failed');
   ?>

   <div class="table-container">
      <table class="cart-table">
         <thead>
            <tr>
               <th>User ID</th>
               <th>Placed On</th>
               <th>Name</th>
               <th>Number</th>
               <th>Email</th>
               <th>Address</th>
               <th>Total Products</th>
               <th>Total Price</th>
               <th>Payment Method</th>
               <th>Payment Status</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
         <?php
         if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
         ?>
            <tr>
               <td><?php echo $fetch_orders['user_id']; ?></td>
               <td><?php echo $fetch_orders['placed_on']; ?></td>
               <td><?php echo $fetch_orders['name']; ?></td>
               <td><?php echo $fetch_orders['number']; ?></td>
               <td><?php echo $fetch_orders['email']; ?></td>
               <td><?php echo $fetch_orders['address']; ?></td>
               <td><?php echo $fetch_orders['total_products']; ?></td>
               <td>₱<?php echo $fetch_orders['total_price']; ?></td>
               <td><?php echo $fetch_orders['method']; ?></td>
               <td>
                  <form action="" method="post" style="display:inline;">
                     <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                     <select name="update_payment" class="select-btn">
                        <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                     </select>
                     <input type="submit" value="update" name="update_order" class="option-btn">
                  </form>
               </td>
               <td>
                  <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
               </td>
            </tr>
         <?php
            }
         }else{
            echo '<tr><td colspan="11" class="empty">no orders placed yet!</td></tr>';
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










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>