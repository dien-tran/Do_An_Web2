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
            <a href="index.html" class="channel-logo"><img src="image/Logo.jpg" alt="Channel Logo"></a>
            <div class="hidden-sidebar your-channel"><img src="" style="height: 30px;" alt="">
            </div>
         </div>
         <div class="middle-sidebar">
            <ul class="sidebar-list">
               <li class="sidebar-list-item tab-content">
                  <a href="admin_main.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-home"></i></div>
                     <div class="hidden-sidebar">Trang tổng quan</div>
                  </a>
               </li>
               <li class="sidebar-list-item tab-content">
                  <a href="admin_products.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-book"></i></div>
                     <div class="hidden-sidebar">Sản phẩm</div>
                  </a>
               </li>
               <li class="sidebar-list-item tab-content">
                  <a href="admin_users.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-group"></i></div>
                     <div class="hidden-sidebar">Khách hàng</div>
                  </a>
               </li>
               <li class="sidebar-list-item tab-content">
                  <a href="admin_orders.php" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-shopping-cart"></i></div>
                     <div class="hidden-sidebar">Đơn hàng</div>
                  </a>
               </li>
               <li class="sidebar-list-item tab-content active">
                  <a href="#" class="sidebar-link">
                     <div class="sidebar-icon"><i class="fa fa-bar-chart"></i></div>
                     <div class="hidden-sidebar">Thống kê</div>
                  </a>
               </li>
            </ul>
         </div>
         <div class="bottom-sidebar">
            <ul class="sidebar-list">
               <li class="sidebar-list-item user-logout">
                  <a href="#" class="sidebar-link" id="logout-acc">
                     <div class="sidebar-icon"><i class="fa fa-arrow-right"></i></div>
                     <div class="hidden-sidebar">Đăng xuất</div>
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
                  <select name="tinh-trang" id="tinh-trang" onchange="findOrder()">
                     <option value="2">Tất cả</option>
                     <option value="1">Đã xử lý</option>
                     <option value="0">Chưa xử lý</option>
                  </select>
               </div>
               <div class="admin-control-center">
                  <form action="" class="form-search">
                     <span class="search-btn"><i class="fa fa-search"></i></span>
                     <input id="form-search-order" type="text" class="form-search-input" placeholder="Tìm kiếm mã đơn, khách hàng..." oninput="findOrder()">
                  </form>
               </div>
               <div class="admin-control-right">
                  <form action="" class="fillter-date">
                     <div>
                        <label for="time-start">Từ</label>
                        <input type="date" class="form-control-date" id="time-start" onchange="findOrder()">
                     </div>
                     <div>
                        <label for="time-end">Đến</label>
                        <input type="date" class="form-control-date" id="time-end" onchange="findOrder()">
                     </div>
                  </form>
                  <button class="btn-reset-order" onclick="cancelSearchOrder()"><i class="fa fa-refresh fa-spin"></i></button>
               </div>
            </div>
            <div class="table">
               <table width="100%">
                  <thead>
                     <tr>
                        <td>Mã đơn</td>
                        <td>Khách hàng</td>
                        <td>Ngày đặt</td>
                        <td>Tổng tiền</td>
                        <td>Trạng thái</td>
                        <td>Thao tác</td>
                     </tr>
                  </thead>
                  <tbody id="showOrder">
                     <?php
                     $select_orders = mysqli_query($conn, "SELECT * FROM orders") or die('query failed');
                     if (mysqli_num_rows($select_orders) > 0) {
                        while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                     ?>
                           <tr>
                              <td value="<?php echo $fetch_orders['id']?>">DH-<?php echo $fetch_orders['id']; ?></td>
                              <td><?php echo $fetch_orders['name'] ?></td>
                              <td><?php echo $fetch_orders['placed_on'] ?></td>
                              <td><?php echo $fetch_orders['total_price'] ?>$</td>
                              <td><?php echo $fetch_orders['payment_status'] ?></td>
                              <td class="control">
                                 <button class="btn-detail" id="" onclick="detailOrder(<?php echo $fetch_orders['id'] ?>)"><i class="	fa fa-asterisk"></i> Chi tiết</button>
                           <?php
                        }
                     }

                           ?>
                           <script>
                              function detailOrder(id) {
                                 document.querySelector(".modal.detail-order").classList.add("open");
                                 
                              }
                              
                           </script>
                              </td>
                           </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="section">
            <div class="admin-control">
               <div class="admin-control-left">
                  <select name="the-loai-tk" id="the-loai-tk" onchange="thongKe()">
                     <option>Tất cả</option>
                     <option>Tiểu thuyết</option>
                     <option>Truyện ngắn</option>
                     <option>Kinh dị</option>
                     <option>Self Help</option>
                  </select>
               </div>
               <div class="admin-control-center">
                  <form action="" class="form-search">
                     <span class="search-btn"><i class="fa fa-search"></i></span>
                     <input id="form-search-tk" type="text" class="form-search-input" placeholder="Tìm kiếm tên sách..." oninput="thongKe()">
                  </form>
               </div>
               <div class="admin-control-right">
                  <form action="" class="fillter-date">
                     <div>
                        <label for="time-start">Từ</label>
                        <input type="date" class="form-control-date" id="time-start-tk" onchange="thongKe()">
                     </div>
                     <div>
                        <label for="time-end">Đến</label>
                        <input type="date" class="form-control-date" id="time-end-tk" onchange="thongKe()">
                     </div>
                  </form>
                  <button class="btn-reset-order" onclick="thongKe(1)"><i class="fa fa-arrow-circle-up"></i></i></button>
                  <button class="btn-reset-order" onclick="thongKe(2)"><i class="fa fa-arrow-circle-o-down"></i></button>
                  <button class="btn-reset-order" onclick="thongKe(0)"><i class="fa fa-circle-o-notch fa-spin"></i></button>
               </div>
            </div>
            <div class="order-statistical" id="order-statistical">
               <div class="order-statistical-item">
                  <div class="order-statistical-item-content">
                     <p class="order-statistical-item-content-desc">Sản phẩm được bán ra</p>
                     <h4 class="order-statistical-item-content-h" id="quantity-product"></h4>
                  </div>
                  <div class="order-statistical-item-icon">
                     <i class="fa-light fa-salad"></i>
                  </div>
               </div>
               <div class="order-statistical-item">
                  <div class="order-statistical-item-content">
                     <p class="order-statistical-item-content-desc">Số lượng bán ra</p>
                     <h4 class="order-statistical-item-content-h" id="quantity-order"></h4>
                  </div>
                  <div class="order-statistical-item-icon">
                     <i class="fa-light fa-file-lines"></i>
                  </div>
               </div>
               <div class="order-statistical-item">
                  <div class="order-statistical-item-content">
                     <p class="order-statistical-item-content-desc">Doanh thu</p>
                     <h4 class="order-statistical-item-content-h" id="quantity-sale"></h4>
                  </div>
                  <div class="order-statistical-item-icon">
                     <i class=""></i>
                  </div>
               </div>
            </div>
            <div class="table">
               <table width="100%">
                  <thead>
                     <tr>
                        <td>STT</td>
                        <td>Tên món</td>
                        <td>Số lượng bán</td>
                        <td>Doanh thu</td>
                        <td></td>
                     </tr>
                  </thead>
                  <tbody id="showTk">
                  </tbody>
               </table>
            </div>
         </div>
      </main>
   </div>
   </div>
   <div class="modal detail-order">
      <div class="modal-container">
         <h3 class="modal-container-title">CHI TIẾT ĐƠN HÀNG</h3>
         <button class="modal-close"><i class="fa fa-close"></i></button>
         <div class="modal-detail-order">
         </div>
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
   <div class="modal signup">
      <div class="modal-container">
         <h3 class="modal-container-title add-account-e">THÊM KHÁCH HÀNG MỚI</h3>
         <h3 class="modal-container-title edit-account-e">CHỈNH SỬA THÔNG TIN</h3>
         <button class="modal-close"><i class="fa fa-close"></i></button>
         <div class="form-content sign-up">
            <form action="" class="signup-form">
               <div class="form-group">
                  <label for="fullname" class="form-label">Tên đầy đủ</label>
                  <input id="fullname" name="fullname" type="text" placeholder="VD: Nhật Sinh" class="form-control">
                  <span class="form-message-name form-message"></span>
               </div>
               <div class="form-group">
                  <label for="phone" class="form-label">Số điện thoại</label>
                  <input id="phone" name="phone" type="text" placeholder="Nhập số điện thoại" class="form-control">
                  <span class="form-message-phone form-message"></span>
               </div>
               <div class="form-group">
                  <label for="password" class="form-label">Mật khẩu</label>
                  <input id="password" name="password" type="text" placeholder="Nhập mật khẩu" class="form-control">
                  <span class="form-message-password form-message"></span>
               </div>
               <div class="form-group edit-account-e">
                  <label for="" class="form-label">Trạng thái</label>
                  <input type="checkbox" id="user-status" class="switch-input">
                  <label for="user-status" class="switch"></label>
               </div>
               <button class="form-submit add-account-e" id="signup-button">Đăng ký</button>
               <button class="form-submit edit-account-e" id="btn-update-account"><i class="fa fa-save"></i> Lưu thông tin</button>
            </form>
         </div>
      </div>
   </div>
   </div>
   <div id="toast"></div>
   <script src="js/admin.js"></script>
</body>

</html>