<?php

include 'config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {
      $message[] = 'user already exist!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'confirm password not matched!';
      } else {
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
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
   <title>Bookept | Register</title>
   <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
   <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
   <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/customers/register.css">

</head>

<body>



   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>

   <div class="form-container ">
      <div class="container">
         <form class="form" action="" method="post">
            <h2>ADD CUSTOMER</h2>
            <div class="input-form"> <!--name -->
               <div class="icon">
                  <img src="./public/form/user.svg" alt="user">
               </div>
               <div class="fill">
                  <input type="text" name="name" placeholder="enter your name" required class="box">
               </div>
            </div>

            <div class="input-form"><!-- email -->
               <div class="icon">
                  <img src="./public/form/letter-svgrepo-com.svg" alt="gmail">
               </div>
               <div class="fill">
                  <input type="email" name="email" placeholder="enter your email" required class="box">
               </div>
            </div>

            <div class="input-form"> <!--pass1 -->
               <div class="icon">
                  <img src="./public//form/finger_print.svg" alt="finger_print"> <!-- dấu pass-->
               </div>
               <div class="fill">
                  <input type="password" name="password" placeholder="enter your password" required class="box">
               </div>
            </div>

            <div class="input-form"> <!--pass2 -->
               <div class="icon">
                  <img src="./public//form/finger_print.svg" alt="finger_print"> <!-- dấu pass-->
               </div>
               <div class="fill">
                  <input type="password" name="password2" placeholder="confirm your password" required class="box">
               </div>
            </div>

            <div class="input-form"> <!--number -->
               <div class="icon">
                  <img src="./public//form/phone-office-svgrepo-com.svg" alt="phone_icon"> <!-- dấu pass-->
               </div>
               <div class="fill">
                  <input type="tel" name="phone" placeholder="Number phone" required class="box">
               </div>
            </div>



            <div class="btn-group">
               <button class="btn" type="submit" name="submit" value="Register" onclick="back()">Add</button>
               <script>
                function back(){
                    window.location.href = "admin_users.php"
                }
               </script>
            </div>

         </form>
      </div>
   </div>

</body>

</html>