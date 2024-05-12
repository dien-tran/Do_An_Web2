<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bookept | About</title>
   <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
   <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
   <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/customers/about.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>about us</h3>
      <p> <a href="home.php">home</a> / about </p>
   </div>

   <section class="about">
      <div class="flex">
         <div class="image">
            <img src="images/about-img.jpg" alt="">
         </div>

         <div class="content">
            <h3>why choose us?</h3>
            <h6>A choice that makes the difference</h6>
            <p>&bull; Professional organization, while always adding value and active in solving customer problems.</p>
            <p>&bull; Dive into our extensive collection of books curated for every reader, from classics to contemporary bestsellers. </p>
            <p>&bull; Immerse yourself in a world of knowledge and imagination, where every page offers an adventure waiting to be discovered. </p>
            <a href="https://www.facebook.com/ScytheTheKiller" class="btn">contact us</a>
         </div>
      </div>
   </section>

   

   <section class="about">
      <div class="flex">
         <div class="content">
            <h3>how we work</h3>
            <p>&bull; Access new ways to increase customer visibility and brand value. As well as looking to make the most of advances in digitization and embracing customer technology platforms.</p>
            <p>&bull; Selecting teams for every project, to ensure each event captures the attention of the people with the most relevant skills. Access partnerships from around the world.</p>
            <!-- <a href="about.php" class="btn">read more</a> -->
         </div>
         <div class="image">
            <img src="images/about-img.jpg" alt="">
         </div>
      </div>
   </section>



   <section class="about">
      <div class="flex">
         <div class="image">
            <img src="images/about-img.jpg" alt="">
         </div>
         <div class="content">
            <h3>about us</h3>
            <p>&bull; Massive business volume for suppliers with profitable contracts.</p>
            
   </section>

   


   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>