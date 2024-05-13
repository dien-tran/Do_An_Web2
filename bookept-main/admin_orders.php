<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
   header('location:login_admin.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href='image/Logo.png' rel='icon' type='image/x-icon' />
   <link rel="stylesheet" href="styles/admin/admin.css">
   <link rel="stylesheet" href="styles/admin/admin-reponsive.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" />


   <link rel="stylesheet" href="">
   <title>Quản lý cửa hàng</title>

</head>

<body>
   <header class="header">
      <button class="menu-icon-btn">
         <div class="menu-icon">
            <i class="fa-regular fa-bars"></i>
         </div>
      </button>
   </header>
   <div class="container">
      <aside class="sidebar open">
         <div class="top-sidebar">
            <a href="admin_main.php" class="channel-logo"><img src="image/homelogo.jpeg" alt="Channel Logo"></a>
            <div class="hidden-sidebar your-channel"><img src="" style="height: 30px;" alt="">
            </div>
         </div>
         <div class="middle-sidebar">
            <ul class="sidebar-list">
               <li id="main" class="sidebar-list-item tab-content">
                  <a href="admin_main.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-home"></i></div>
                     <div class="hidden-sidebar">Overview</div>
                  </a>
               </li>
               <li class="sidebar-list-item tab-content">
                  <a href="admin_products.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-book"></i></div>
                     <div class="hidden-sidebar">Products</div>
                  </a>
               </li>
               <li id="customers" class="sidebar-list-item tab-content">
                  <a href="admin_users.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-group"></i></div>
                     <div class="hidden-sidebar">Customer</div>
                  </a>
               </li>
               <li class="sidebar-list-item tab-content active">
                  <a href="admin_orders.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-shopping-cart"></i></div>
                     <div class="hidden-sidebar">Order</div>
                  </a>
               </li>
               <li class="sidebar-list-item tab-content">
                  <a href="admin_stats.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-bar-chart"></i></div>
                     <div class="hidden-sidebar">Statistical</div>
                  </a>
               </li>
            </ul>
         </div>
         <div class="bottom-sidebar">
            <ul class="sidebar-list">
               <li class="sidebar-list-item user-logout">
                  <a href="" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-arrow-right"></i></div>
                     <div class="hidden-sidebar" onclick="redirectToLogout()">Logout</div>
                     <script>
                        function redirectToLogout() {
                           window.location.href = "logout_admin.php";
                        }
                     </script>
                  </a>
               </li>
            </ul>
         </div>
      </aside>
      <main class="content">
         <!-- Order  -->
         <div class="section active">
            <div class="admin-control">
               <div class="admin-control-left">
                  <form method="get">
                     <select name="district" id="district">
                        <option value="2" selected disabled>District</option>
                        <?php

                        for ($i = 1; $i <= 12; $i++) {
                           echo "<option value='District $i'>District $i</option>";
                        }
                        ?>
                     </select>
                     <select name="ward" id="ward">
                        <option value="2" selected disabled>Ward</option>
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                           echo "<option value='Ward $i'>Ward $i</option>";
                        }
                        ?>
                     </select>
                     <select name="payment_status">
                        <option disabled selected>Payment Status</option>
                        <option value="Cancel">Cancel</option>
                        <option value="pending">pending</option>
                        <option value="Completed">Completed</option>
                     </select>
               </div>
               <div class="admin-control-right">
                  <div>
                     <label for="start_date">From:</label>
                     <input class="form-control-date" type="date" id="start_date" name="start_date">
                  </div>
                  <div>
                     <label for="end_date">To:</label>
                     <input class="form-control-date" type="date" id="end_date" name="end_date">
                  </div>
                  
               </div>
               <button class="btn-control-large" type="submit" name="submit">Search</button>
               </form>
            </div>
            <div class="table">
               <table width="100%">
                  <thead>
                     <tr>
                        <td>ID Orders</td>
                        <td>Customer</td>
                        <td>Order date</td>
                        <td>Total price</td>
                        <td>Status</td>
                        <td>Action</td>
                     </tr>
                  </thead>
                  <tbody id="showOrder">
                     <?php
                     
                     if (isset($_GET['district']) && isset($_GET['ward']) && !isset($_GET['payment_status']) && $_GET['start_date'] == "") {
                        $district = $_GET['district'];
                        $ward = $_GET['ward'];
                        $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE ward = '$ward' AND district = '$district'") or die('query failed');
                        if (mysqli_num_rows($select_orders) > 0) {
                           while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                     ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        } elseif (isset($_GET['district']) && !isset($_GET['ward']) && !isset($_GET['payment_status']) && $_GET['start_date'] == "") {
                           $district = $_GET['district'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE district = '$district'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        } elseif (isset($_GET['ward']) && !isset($_GET['district']) && !isset($_GET['payment_status']) && $_GET['start_date'] == "") {
                           $ward = $_GET['ward'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE ward = '$ward'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        } 
                        elseif (isset($_GET['payment_status']) && !isset($_GET['ward']) && !isset($_GET['district']) && $_GET['start_date'] == "") {
                           $pay = $_GET['payment_status'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE payment_status = '$pay'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        } 
                        elseif (isset($_GET['district']) && isset($_GET['payment_status']) && !isset($_GET['ward']) && $_GET['start_date'] == "") {
                           $district = $_GET['district'];
                           $pay = $_GET['payment_status'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE district = '$district' AND payment_status = '$pay'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['ward']) && isset($_GET['payment_status']) && !isset($_GET['district']) && $_GET['start_date'] == "") {

                           $ward = $_GET['ward'];
                           $pay = $_GET['payment_status'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE ward = '$ward' AND payment_status = '$pay'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['district']) && isset($_GET['ward']) && isset($_GET['payment_status']) && $_GET['start_date'] == "") {
                           $district = $_GET['district'];
                           $ward = $_GET['ward'];
                           $pay = $_GET['payment_status'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE district = '$district' AND ward = '$ward' AND payment_status = '$pay'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['start_date']) && $_GET['start_date'] != "" && !isset($_GET['payment_status']) && !isset($_GET['ward']) && !isset($_GET['district'])) {
                           $start_date = $_GET['start_date'];
                           $end_date = $_GET['end_date'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE placed_on BETWEEN '$start_date' AND '$end_date'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['ward']) && isset($_GET['start_date']) && isset($_GET['end_date']) && !isset($_GET['payment_status']) && !isset($_GET['district'])) {
                           $ward = $_GET['ward'];
                           $start = $_GET['start_date'];
                           $end = $_GET['end_date'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE ward = '$ward' AND placed_on BETWEEN '$start' AND '$end'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['district']) && isset($_GET['start_date']) && !isset($_GET['payment_status']) && !isset($_GET['ward']) && isset($_GET['end_date'])) {
                           $district = $_GET['district'];
                           $start = $_GET['start_date'];
                           $end = $_GET['end_date'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE district = '$district' AND placed_on BETWEEN '$start' AND '$end'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['payment_status']) && isset($_GET['start_date']) && !isset($_GET['ward']) && !isset($_GET['district']) && isset($_GET['end_date'])) {
                           $pay = $_GET['payment_status'];
                           $start = $_GET['start_date'];
                           $end = $_GET['end_date'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE payment_status = '$pay' AND placed_on BETWEEN '$start' AND '$end'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['district']) && isset($_GET['ward']) && isset($_GET['start_date']) && !isset($_GET['payment_status']) && isset($_GET['end_date'])) {
                           $ward = $_GET['ward'];
                           $district = $_GET['district'];
                           $start = $_GET['start_date'];
                           $end = $_GET['end_date'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE district = '$district' AND ward = '$ward' AND placed_on BETWEEN '$start' AND '$end'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['district']) && isset($_GET['ward']) && isset($_GET['payment_status']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
                           $ward = $_GET['ward'];
                           $district = $_GET['district'];
                           $pay = $_GET['payment_status'];
                           $start = $_GET['start_date'];
                           $end = $_GET['end_date'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE payment_status = '$pay' AND district = '$district' AND ward = '$ward' AND placed_on BETWEEN '$start' AND '$end'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif (isset($_GET['district']) && !isset($_GET['ward']) && isset($_GET['payment_status']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
                           $district = $_GET['district'];
                           $pay = $_GET['payment_status'];
                           $start = $_GET['start_date'];
                           $end = $_GET['end_date'];
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders o INNER JOIN users u ON o.user_id = u.id WHERE payment_status = '$pay' AND district = '$district' AND placed_on BETWEEN '$start' AND '$end'") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                                 <?php
                              }
                           }
                        }
                        elseif(!isset($_GET['district']) && !isset($_GET['ward']) && !isset($_GET['payment_status'])) {
                           $select_orders = mysqli_query($conn, "SELECT * FROM orders") or die('query failed');
                           if (mysqli_num_rows($select_orders) > 0) {
                              while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                 ?>
                              <tr>
                                 <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                 <td><?php echo $fetch_orders['name'] ?></td>
                                 <td><?php echo $fetch_orders['placed_on'] ?></td>
                                 <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                 <td><?php echo $fetch_orders['payment_status'] ?></td>
                                 <td class="control">
                                    <form method="post">
                                       <button class='btn-detail'><a style="color:black" href="admin_orderdetail.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a></button>
                                    </form>
                           <?php
                              }
                           }
                        }

                           ?>
                                 </td>
                              </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </main>
   </div>
   </div>
   <div class="modal detail-order" id="a">
      <div class="modal-container">
         <h3 class="modal-container-title">CHI TIẾT ĐƠN HÀNG</h3>
         <?php

         // $order_id = '<script>document.writeln(orderId);</script>';
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $order_id = $_POST['order_id'];
            echo "orderid" . $order_id;
            $sql = mysqli_query($conn, "SELECT * FROM orders where id = '$order_id'");

            if (mysqli_num_rows($sql) > 0) {
               while ($fetch = mysqli_fetch_assoc($sql)) {

         ?>
                  <button class="modal-close"><i class="fa fa-close"></i></button>
                  <div class="modal-detail-order">
                     <div class="modal-detail-left">
                        <div class="order-product">
                           <div class="order-product-left">
                              <img src="<?php echo $fetch['Image'] ?>" alt="">
                              <div class="order-product-info">
                                 <h4></h4>
                                 <p class="order-product-quantity">SL:
                                 <p>
                              </div>
                           </div>
                        </div>
                        <div class="order-product-right">
                           <div class="order-product-price">
                              <span class="order-product-current-price"><?php echo $fetch['Price'] ?></span>
                           </div>
                        </div>
                     </div>
                     <div class="modal-detail-right">
                        <ul class="detail-order-group">
                           <li class="detail-order-item">
                              <span class="detail-order-item-left"><i class="fa fa-calendar"></i> Ngày đặt hàng</span>
                              <span class="detail-order-item-right"> <?php echo $fetch['placed_on'] ?></span>
                           </li>
                           <li class="detail-order-item">
                              <span class="detail-order-item-left"><i class="fa fa-user"></i> Người nhận</span>
                              <span class="detail-order-item-right"><?php echo $fetch['name'] ?></span>
                           </li>
                           <li class="detail-order-item">
                              <span class="detail-order-item-left"><i class="fa fa-phone"></i> Số điện thoại</span>
                              <span class="detail-order-item-right"><?php echo $fetch['number'] ?></span>
                           </li>
                           <li class="detail-order-item">
                              <span class="detail-order-item-left"><i class="fa fa-credit-card"></i> Phương thức</span>
                              <span class="detail-order-item-right"><?php echo $fetch['method'] ?></span>
                           </li>
                           <li class="detail-order-item tb">
                              <span class="detail-order-item-t"><i class="fa fa-location-arrow"></i> Địa chỉ nhận</span>
                              <p class="detail-order-item-b"><?php echo $fetch['address'] ?></p>
                           </li>
                        </ul>
                     </div>
                  </div>
         <?php
               }
            }
         } ?>
         <div class="modal-detail-bottom">
         </div>

         </form>
      </div>
   </div>
   <div class="modal detail-order-product">
      <div class="modal-container">
         <button class="modal-close"><i class="fa fa-close"></i></button>
         <div class="table">
            <table width="100%">
               <thead>
                  <tr>
                     <td>Mã đơn</td>
                     <td>Số lượng</td>
                     <td>Đơn giá</td>
                     <td>Ngày đặt</td>
                  </tr>
               </thead>
               <tbody id="show-product-order-detail">
               </tbody>
            </table>
         </div>
         </form>
      </div>
   </div>

   <script src="js/admin.js">

   </script>
</body>

</html>