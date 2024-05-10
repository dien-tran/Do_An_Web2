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

   // Lấy thông tin sản phẩm cần cập nhật số lượng
   $cart_info_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE id = '$cart_id'");
   $fetch_cart_info = mysqli_fetch_assoc($cart_info_query);
   $product_name = mysqli_real_escape_string($conn, $fetch_cart_info['name']);

   // Lấy số lượng hiện tại của sản phẩm trong giỏ hàng
   $current_cart_quantity = $fetch_cart_info['quantity'];

   // Lấy thông tin số lượng sản phẩm trong bảng products
   $sql_product_quantity_table = "SELECT Quantity FROM products WHERE Name = '$product_name'";
   $result_product_quantity = mysqli_query($conn, $sql_product_quantity_table);
   if ($result_product_quantity) {
      $row = mysqli_fetch_assoc($result_product_quantity);
      $current_product_quantity = $row['Quantity'];

      // Tính toán sự khác biệt giữa số lượng mới và số lượng hiện tại
      $quantity_difference_after_update = $cart_quantity - $current_cart_quantity;
      
      // Kiểm tra sự khác biệt và thực hiện cập nhật số lượng sản phẩm trong bảng products
      if ($quantity_difference_after_update < 0) {
         // Cộng số lượng sản phẩm nếu sự khác biệt là số âm
         $new_quantity_after_update = $current_product_quantity + abs($quantity_difference_after_update) + 1;
      } else {
         // Trừ số lượng sản phẩm nếu sự khác biệt là số dương
         $new_quantity_after_update = $current_product_quantity - $quantity_difference_after_update + ($cart_quantity);
      }

      // Cập nhật số lượng mới vào bảng products
      $update_quantity_productTable = mysqli_query($conn, "UPDATE products SET Quantity = $new_quantity_after_update WHERE Name = '$product_name'");
      if (!$update_quantity_productTable) {
         echo "Lỗi: " . mysqli_error($conn);
      }

      // Cập nhật số lượng trong giỏ hàng sau khi cập nhật thành công số lượng trong bảng sản phẩm
      mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
      $message[] = 'Cart quantity updated!';
   } else {
      echo "Lỗi: " . mysqli_error($conn);
   }
}


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   
   // Lấy thông tin sản phẩm cần xóa
   $cart_product_info = mysqli_query($conn, "SELECT * FROM cart WHERE id = '$delete_id'");
   $fetch_cart = mysqli_fetch_assoc($cart_product_info);
   $product_name = mysqli_real_escape_string($conn, $fetch_cart['name']);
   $cart_quantity = $fetch_cart['quantity'];
   
   // Xóa sản phẩm khỏi giỏ hàng
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');

   // Truy vấn và cập nhật lại số lượng trong bảng products
   $sql_product_quantity_table = "SELECT Quantity FROM products WHERE Name = '$product_name'";
   $result_product_quantity = mysqli_query($conn, $sql_product_quantity_table);
   if ($result_product_quantity) {
      $row = mysqli_fetch_assoc($result_product_quantity);
      $current_quantity = $row['Quantity'];
      
      // Cập nhật lại số lượng sản phẩm trong bảng products
      $new_quantity = $current_quantity + $cart_quantity;
      $update_quantity_productTable = mysqli_query($conn, "UPDATE products SET Quantity = $new_quantity WHERE Name = '$product_name'");
      if (!$update_quantity_productTable) {
         echo "Lỗi: " . mysqli_error($conn);
      }
   } else {
      echo "Lỗi: " . mysqli_error($conn);
   }
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   // Lấy thông tin sản phẩm trong giỏ hàng của user
   $cart_product_info = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
   while ($fetch_cart = mysqli_fetch_assoc($cart_product_info)) {
      $product_name = mysqli_real_escape_string($conn, $fetch_cart['name']);
      $cart_quantity = $fetch_cart['quantity'];

      // Truy vấn và cập nhật lại số lượng trong bảng products cho từng sản phẩm
      $sql_product_quantity_table = "SELECT Quantity FROM products WHERE Name = '$product_name'";
      $result_product_quantity = mysqli_query($conn, $sql_product_quantity_table);
      if ($result_product_quantity) {
         $row = mysqli_fetch_assoc($result_product_quantity);
         $current_quantity = $row['Quantity'];

         // Cập nhật lại số lượng sản phẩm trong bảng products
         $new_quantity = $current_quantity + $cart_quantity;
         $update_quantity_productTable = mysqli_query($conn, "UPDATE products SET Quantity = $new_quantity WHERE Name = '$product_name'");
         if (!$update_quantity_productTable) {
            echo "Lỗi: " . mysqli_error($conn);
         }
      } else {
         echo "Lỗi: " . mysqli_error($conn);
      }
   }
   
   // Xóa toàn bộ giỏ hàng của user
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
   <title>Bookept | Cart</title>
   <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
   <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
   <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/customers/cart.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>shopping cart</h3>
   <p> <a href="home.php">home</a> / cart </p>
</div>

<section class="cart-container">
   <div class="cart-head">
      <?php $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed'); ?>
      <div class="head-left">
         <h2>My List</h2>
         <h6>&bull; <?php echo mysqli_num_rows($select_cart) ?> items</h6>
      </div>
<<<<<<< HEAD
      <!-- <div>
         <select name="sort_cart" id="sort_cart">
            <option value="default">default</option>
            <option value="alphabet">a-z</option>
            <option value="low_to_high_price">Low to high price</option>
         </select>
      </div> -->
=======
>>>>>>> e77710153e987a350dd2bcff3c3b3e4ee66ec828
   </div>

   <ul class="cart-list">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <li class="cart-item">
         <div class="cart-item-content">
            <div class="image">
               <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
            </div>
            <div class="name">
               <h2><?php echo $fetch_cart['name']; ?></h2>
               <p>#id: <?php echo $fetch_cart['id']; ?></p>
            </div>
         </div>
         <form action="" method="post" class="cart-item-metrics">
            <div class="item-quantity">
               <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
               <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            </div>
            <div class="item-price">
               <div>
                  <div class="price">$<?php echo $fetch_cart['price']; ?> <span style="font-size: 1em; color:#888"> &bull; (<?php echo $sub_total = ($fetch_cart['quantity']); ?>)</span></div>
                  <?php
                  $product_name = mysqli_real_escape_string($conn, $fetch_cart['name']);
                  $cart_quantity = $fetch_cart['quantity'];
                  $cart_product_info = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name'");
                  $result_cart_product_info = mysqli_fetch_assoc($cart_product_info);
            
                  // Truy vấn và cập nhật lại giá trị Quantity trong bảng products
                  $sql_product_quantity_table = "SELECT Quantity FROM products WHERE Name = '$product_name'";
                  $result_product_quantity = mysqli_query($conn, $sql_product_quantity_table);
                  if ($result_product_quantity ) {
                     $row = mysqli_fetch_assoc($result_product_quantity);
                     $current_quantity = $row['Quantity'];
                     $new_quantity = $current_quantity - $cart_quantity;
            
                     // Cập nhật giá trị mới vào bảng products
                     $update_quantity_productTable = mysqli_query($conn, "UPDATE products SET Quantity = $new_quantity WHERE Name = '$product_name'");
                     if (!$update_quantity_productTable) {
                        echo "Lỗi: " . mysqli_error($conn);
                     }
                  } else {
                     echo "Lỗi: " . mysqli_error($conn);
                  }
                  ?>
                  <div class="sub-total"> sub total : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?></span></div>
               </div>
            </div>
            <div class="item-btn">
               <button type="submit" name="update_cart" value="update" class="option-btn">update</button>
            </div>
            <div class="item-delete">
               <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
            </div>
         </form>
      </li>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">your cart is empty</p>';
      }
      ?>
      <li class="cart-action">
         <div class="cart-btn">
            <a href="shop.php" class="option-btn"><img src="./public/cart/continue.svg" alt="continue_icon">continue shopping</a>
            <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>"><img src="./public/cart/checkout.svg" alt="checkout_icon">proceed to checkout</a>
            <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');"><img src="./public/cart/remove.svg" alt="delete_all_icon">delete all</a>
         </div>
         <div class="cart-total">
            <p>grand total : <span>$<?php echo $grand_total; ?></span></p>
         </div>
      </li>
   </ul>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>