<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['order_btn'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $house_number = mysqli_real_escape_string($conn, $_POST['house-num']);
   $road = mysqli_real_escape_string($conn, $_POST['road']);
   $ward = mysqli_real_escape_string($conn, $_POST['ward']);
   $district =  mysqli_real_escape_string($conn, $_POST['district']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);

   $address = "flat no. $house_number, $road, $ward, $district, $city, $country";
   $placed_on = date('Y-m-d');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if (mysqli_num_rows($cart_query) > 0) {
      while ($cart_item = mysqli_fetch_assoc($cart_query)) {
         $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ', $cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if ($cart_total == 0) {
      $message[] = 'your cart is empty';
   } else {
      if (mysqli_num_rows($order_query) > 0) {
         $message[] = 'order already placed!';
      } else {
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
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
   <title>Bookept | Checkout</title>
   <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
   <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
   <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="./styles/customers/checkout.css">
   <style>
      .form-select {

         font-size: 16px;
         display: inline-block;
         width: 33.33%;
         margin-right: 20px;
         width: 100%;
         /* Đặt chiều rộng là 100% để các select box dài hết chiều rộng của cột */
         max-width: 400px;
         /* Tùy chỉnh chiều rộng tối đa của các select box */
      }
   </style>
</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>checkout</h3>
      <p> <a href="home.php">home</a> / checkout </p>
   </div>
   <?php
   $user_id = $_SESSION['user_id'];
   $sql = mysqli_query($conn, "SELECT * FROM  `users` WHERE id=$user_id");
   $check = mysqli_fetch_assoc($sql);
   ?>
   <section class="checkout-container">
      <form action="" method="post">
         <h3><i class="fa-solid fa-folder-open"></i> place your order</h3>
         <div class="flex">
            <div class="inputBox">
               <span><i class="fa-solid fa-signature"></i> your name :</span>
               <input type="text" name="name" value="<?php echo $check['name']; ?>">
            </div>
            <div class="inputBox">
               <span><i class="fa-solid fa-hashtag"></i> your number :</span>
               <input type="text" name="number" value="<?php echo $check['phone_number']; ?>">
            </div>
            <div class="inputBox">
               <span><i class="fa-solid fa-at"></i> your email :</span>
               <input type="email" name="email" value="<?php echo $check['email']; ?>">
            </div>
            <div class="inputBox">
               <span><i class="fa-solid fa-money-check-dollar"></i> payment method :</span>
               <select name="method">
                  <option value="cash on delivery">cash on delivery</option>
                  <option value="credit card">credit card</option>
                  <option value="paypal">paypal</option>
                  <option value="momo">momo</option>
                  <option value="visa debit">visa debit</option>
               </select>
            </div>
            <div class="inputBox">
               <span><i class="fa-solid fa-house"></i> house number :</span>
               <input required type="text" min="0" name="house-num" value="<?php echo $check['house_number']; ?>">
            </div>
            <div class="inputBox">
               <span><i class="fa-solid fa-location-dot"></i> road :</span>
               <input required type="text" name="road" value="<?php echo $check['road']; ?>">
            </div>
            <div class="inputBox">
               <span><i class="fa-solid fa-location-dot"></i> ward :</span>
               <br>
               <select required class="" name="ward" id="ward">
                  <option value="" selected disabled>Choose ward</option>
                  <?php
                  for ($i = 1; $i <= 12; $i++) {
                     $selected = ($_POST['ward'] == "Ward $i") ? 'selected' : '';
                     "<option value='Ward $i' $selected >Ward $i</option>";
                     $selected = ($check['ward'] == "Ward $i") ? 'selected' : '';
                     echo "<option value='Ward $i' $selected>Ward $i</option>";
                  }
                  ?>
               </select>
            </div>
            <div class="inputBox">
               <span><i class="fa-solid fa-location-dot"></i> district :</span>
               <br>
               <select required class="" name="district" id="district" aria-label=".form-select-sm">
                  <option value="" selected disabled>Choose district</option>
                  <?php
                  for ($i = 1; $i <= 12; $i++) {
                     $selected = ($_POST['district'] == "District $i") ? 'selected' : '';
                     "<option value='District $i' $selected>District $i</option>";
                     $selected = ($check['district'] == "District $i") ? 'selected' : '';
                     echo "<option value='District $i' $selected>District $i</option>";
                  }
                  ?>
               </select>
            </div>
            <div class="inputBox">
               <span><i class="fa-solid fa-location-dot"></i> city :</span>
               <br>
               <select required class="" name="city" id="city" style="width: 49.3%;">
                  <option value="" selected disabled>Choose city</option>
                  <option value="Hồ Chí Minh" selected>Ho Chi Minh city</option>
               </select>
            </div>
         </div>

         <div style="display: flex; justify-content:end">
            <input type="submit" value="🚩 order now" class="btn" name="order_btn">
         </div>
      </form>

      <?php
      $grand_total = 0;

      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      ?>

      <?php


      if (isset($_POST['order_btn'])) {
         // Lấy thông tin từ form
         $number = mysqli_real_escape_string($conn, $_POST['number']);
         $email = mysqli_real_escape_string($conn, $_POST['email']);
         $house_number = mysqli_real_escape_string($conn, $_POST['house-num']);
         $road = mysqli_real_escape_string($conn, $_POST['road']);
         $ward = mysqli_real_escape_string($conn, $_POST['ward']);
         $district = mysqli_real_escape_string($conn, $_POST['district']);
         $city = mysqli_real_escape_string($conn, $_POST['city']);

         // Kiểm tra xem email đã tồn tại trong bảng users chưa
         $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
         $result_check_email = mysqli_query($conn, $sql_check_email);

         if (mysqli_num_rows($result_check_email) > 0) {
            // Cập nhật thông tin người dùng nếu email đã tồn tại
            $sql_update_user = "UPDATE users SET  phone_number = '$number',  house_number = '$house_number', road = '$road', city = '$city', district = '$district', ward = '$ward' WHERE email = '$email'";
            if (mysqli_query($conn, $sql_update_user)) {
               echo "<strong style='font-size:14px;'>Thông tin người dùng đã được cập nhật thành công !</strong>";
            } else {
               echo "Lỗi: " . mysqli_error($conn);
            }
         }
      }
      ?>
      <div class="summary-order">
         <div class="summary-header">
            <h2><i class="fa-solid fa-cart-flatbed"></i> Your cart</h2>
            <h5 style="background: #888; border-radius: 50%; width:3.5rem; height:3.5rem; color:white; display:flex; justify-content:center; align-items:center"><?php echo mysqli_num_rows($select_cart) ?></h5>
         </div>
         <div class="summary-list">
            <?php
            if (mysqli_num_rows($select_cart) > 0) {
               while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                  $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                  $grand_total += $total_price;
                  $name = $fetch_cart['name'];
                  mysqli_query($conn, "UPDATE products SET SoldYet = 'Yes' WHERE Name = '$name'") or die('query failed');
            ?>
                  <div class="summary-item">
                     <p><?php echo $fetch_cart['name']; ?></p>
                     <p><?php echo '$' . $fetch_cart['price']; ?> &bull; <?php echo $fetch_cart['quantity']; ?></p>
                  </div>
            <?php
               }
            } else {
               echo '<p class="empty">your cart is empty</p>';
            }
            ?>
         </div>
         <div class="summary-total">
            <p><i class="fa-solid fa-border-all"></i> grand total : </p>
            <p style="color:red">$<?php echo $grand_total; ?></p>
         </div>
      </div>
   </section>

   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js">

   </script>

</body>

</html>