<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/icon.png" type="image/png">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      
      <h3>Hand Picked Book to your door</h3>
      <p>Pick a book and receive them in your doorstep</p>
      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php  
         $products_per_page = 4;
         $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
         $start_from = ($page - 1) * $products_per_page;

         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT $start_from, $products_per_page") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
   <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo urlencode($fetch_products['image']); ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">₱<?php echo $fetch_products['price']; ?>/-</div>
   <?php if ($fetch_products['stock'] == 0): ?>
         <div class="stock" style="color: #c0392b; font-weight: bold;">Out of Stock</div>
            <input type="number" min="1" name="product_quantity" value="1" class="qty" disabled>
            <input type="submit" value="add to cart" name="add_to_cart" class="btn" disabled style="background:#ccc;cursor:not-allowed;">
   <?php else: ?>
         <div class="stock" style="color: #27ae60; font-weight: bold;">Stock: <?php echo $fetch_products['stock']; ?></div>
            <input type="number" min="1" max="<?php echo $fetch_products['stock']; ?>" name="product_quantity" value="1" class="qty">
            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
   <?php endif; ?>
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

<?php
// Pagination controls
$total_products_query = mysqli_query($conn, "SELECT COUNT(*) FROM `products`") or die('query failed');
$total_products_row = mysqli_fetch_row($total_products_query);
$total_products = $total_products_row[0];
$total_pages = ceil($total_products / $products_per_page);

if ($total_pages > 1) {
    echo '<div class="pagination">';
    if($page > 1){
        echo '<a href="shop.php?page='.($page-1).'" class="btn">Prev</a>';
    }
    for($i = 1; $i <= $total_pages; $i++){
        if($i == $page){
            echo '<span class="btn" style="background:#753e26;">'.$i.'</span>';
        }else{
            echo '<a href="shop.php?page='.$i.'" class="btn">'.$i.'</a>';
        }
    }
    if($page < $total_pages){
        echo '<a href="shop.php?page='.($page+1).'" class="btn">Next</a>';
    }
    echo '</div>';
}
?>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about2.png" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>Welcome to Bound and Noble, your cozy escape into the world of stories, ideas, and imagination.
            Whether you're a lifelong reader or just starting your literary journey, our bookstore is here to inspire and connect.
            Founded with a deep love for books and a belief in their power to transform lives, we offer a carefully curated collection of fiction, 
            non-fiction, classics, children's books, and local authors. Every shelf holds something waiting to be discovered. </p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>If you have any further questions or concerns clikc the contact button and message us, we will get back to you as soon as we can.</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>