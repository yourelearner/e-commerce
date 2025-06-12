<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/icon.png" type="image/png">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <img src="images/about.png" alt="">
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about2.png" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>We provide quality, new and original books. We make sure that all books are taken care of before shipped to you.</p>
         <p>Enjoy reading with us by supporting our book store. Happy shopping!</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic-1.png" alt="">
         <p>Shopping on this site was so easy—everything from browsing to checkout was smooth and intuitive.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>John Mark</h3>
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>This site makes buying books online feel personal and enjoyable.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Sophie Dagok</h3>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p>I was impressed by how quickly my order arrived and how carefully it was packaged.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Marcus Apollo</h3>
      </div>
   </div>

</section>

<section class="authors">

   <h1 class="title">Greate Authors</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/author-Julia Quinn.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Julia Quinn</h3>
      </div>

      <div class="box">
         <img src="images/author-Colleen Hoover.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Colleen Hoover</h3>
      </div>

      <div class="box">
         <img src="images/author-Jenny Hann.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Jenny Hann</h3>
      </div>
   </div>

</section>




<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>