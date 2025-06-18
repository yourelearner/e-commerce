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
      $message[] = 'Already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'Product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/icon.png" type="image/png">

   <style>
   .products .box-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      max-width: 1200px;
      margin: 0 auto;
      align-items: flex-start;
   }
   .products .box {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      text-align: center;
      padding: 2rem;
      border-radius: .5rem;
      border: 1px solid #333;
      box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
      background-color: #fff;
   }
   .products .box .image {
      width: 100%;
      height: 20rem;
      object-fit: cover;
      border-radius: .5rem;
      margin-bottom: 1rem;
   }
   .products .box .name {
      padding: 1rem 0;
      font-size: 2rem;
      color: #333;
   }
   .products .box .price {
      padding: 1rem 0;
      font-size: 2.5rem;
      color: #c0392b;
   }
   .pagination {
      text-align: center;
      margin: 2rem 0;
   }
.pagination .btn, .pagination span.btn {
    display: inline-block;
    margin: 0 0.2rem;
    padding: 1rem 2rem;
    font-size: 1.6rem;
    border-radius: .5rem;
    background: #753e26;
    color: #fff;
    cursor: pointer;
    text-decoration: none;
    border: none;
}
.pagination .btn:hover {
   background: white
   color: #a74e1d  
}
   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

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
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">₱<?php echo $fetch_products['price']; ?>/-</div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
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

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>