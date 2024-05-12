<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
    header('location:login_admin.php');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy orderId từ yêu cầu POST
    $orderId = $_GET['order_id'];
    $sql = "UPDATE orders SET payment_status = 'Completed' WHERE id = '$orderId'";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
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
                    <li class="sidebar-list-item tab-content active">
                        <a href="admin_orders.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-shopping-cart"></i></div>
                            <div class="hidden-sidebar">Đơn hàng</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content">
                        <a href="admin_stats.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-bar-chart"></i></div>
                            <div class="hidden-sidebar">Thống kê</div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-sidebar">
                <ul class="sidebar-list">
                    <li class="sidebar-list-item user-logout">
                        <a href="admin_stats.php" class="sidebar-link" id="logout-acc">
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
                                        <td value="<?php echo $fetch_orders['id'] ?>">DH-<?php echo $fetch_orders['id']; ?></td>
                                        <td><?php echo $fetch_orders['name'] ?></td>
                                        <td><?php echo $fetch_orders['placed_on'] ?></td>
                                        <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                        <td><?php echo $fetch_orders['payment_status'] ?></td>
                                        <td class="control">
                                            <a style="color:black" href="admin_orderdetail.php?order_id= <?php echo $fetch_orders['id']; ?>"><i onclick="detailOrder()" class=" fa fa-asterisk"></i> Chi tiết</a>
                                    <?php
                                }
                            }

                                    ?>
                                    <script>
                                        function detailOrder() {
                                            document.querySelector(".modal.detail-order").classList.add("open");
                                        };
                                    </script>
                                        </td>
                                    </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    </div>
    <div class="modal detail-order open" id="a">
        <div class="modal-container">
            <h3 class="modal-container-title">CHI TIẾT ĐƠN HÀNG</h3>
            <form name="form" action="" method="post">
                <input type="hidden" id="order_id_input" name="order_id">
            </form>
            <?php
            // Lấy order_id từ tham số GET
            $order_id = $_GET['order_id'];

            // Truy vấn để lấy thông tin đơn hàng từ CSDL
            $sql_order = mysqli_query($conn, "SELECT * FROM orders where id = '$order_id'");
            $result_order = mysqli_fetch_assoc($sql_order);


            // Kiểm tra xem có đơn hàng nào được tìm thấy không
            if ($result_order) {
            ?>
                <div class="modal-detail-order">
                    <a href="admin_orders.php"><button class="modal-close"><i class="fa fa-close"></i></button></a>
                    <div class="modal-detail-left">
                        <div class="order-item-group">
                            <?php
                            // Truy vấn để lấy thông tin chi tiết sản phẩm trong đơn hàng
                            $total_products = $result_order['total_products']; // Lấy giá trị từ cột total_products
                            $products_array = explode(',', $total_products); // Tách các sản phẩm thành mảng
                            $product_number = 1;

                            if (count($products_array) > 0) {
                                array_shift($products_array); // Bỏ qua phần tử đầu tiên của mảng
                            }

                            foreach ($products_array as $product_string) {
                                // Tách tên sản phẩm và số lượng
                                $product_data = explode('(', $product_string);
                                $product_name = trim($product_data[0]); // Tên sản phẩm
                                $product_quantity = intval($product_data[1]); // Số lượng sản phẩm

                                // $sql_product_image = mysqli_query($conn,"SELECT Image FROM products  JOIN orders ON products.name =   $product_name ");

                                // $product_img = mysqli_fetch_assoc($sql_product_image);    
                                $sql_product_image = mysqli_query($conn, "SELECT Image FROM products WHERE Name = '$product_name'");
                                $product_img_data = mysqli_fetch_assoc($sql_product_image);
                                $product_img_url = $product_img_data['Image'];

                                // Truy vấn cơ sở dữ liệu để lấy thông tin về sản phẩm
                                $sql_product = mysqli_query($conn, "SELECT * FROM products WHERE name='$product_name'");
                                $product_detail = mysqli_fetch_assoc($sql_product);

                                // Tính toán tổng tiền cho sản phẩm
                                $product_price = $product_detail['Price']; // Giá của sản phẩm
                                $total_price = $product_price * $product_quantity; // Tổng tiền cho sản phẩm

                                $product_number++;

                                echo '<div class="order-product">';
                                echo '<div class="order-product-left">';
                                echo '<div class="order-product-left">';
                                echo '<img src="image/' . $product_img_url . '" alt="">';


                                echo '<div class="order-product-info">';
                                echo '<h4>' . $product_name . '</h4> ';
                                echo '<h4> Price: $' . $total_price . '</h4>';
                                echo '<p class="order-product-quantity">SL: ' . $product_quantity . '<p>';
                                echo '</div>';
                                echo '</div>';
                            ?>
                        </div>
                    </div>
                <?php } ?>
                </div>
        </div>
        <div class="modal-detail-right">
            <ul class="detail-order-group">
                <li class="detail-order-item">
                    <span class="detail-order-item-left"><i class="fa fa-calendar"></i> Ngày đặt hàng</span>
                    <span class="detail-order-item-right"><?php echo $result_order['placed_on']; ?></span>
                </li>
                <li class="detail-order-item">
                    <span class="detail-order-item-left"><i class="fa fa-user"></i> Người nhận</span>
                    <span class="detail-order-item-right"><?php echo $result_order['name'] ?></span>
                </li>
                <li class="detail-order-item">
                    <span class="detail-order-item-left"><i class="fa fa-phone"></i> Số điện thoại</span>
                    <span class="detail-order-item-right"><?php echo $result_order['number'] ?></span>
                </li>
                <li class="detail-order-item">
                    <span class="detail-order-item-left"><i class="fa fa-credit-card"></i> Phương thức</span>
                    <span class="detail-order-item-right"><?php echo $result_order['method'] ?></span>
                </li>
                <li class="detail-order-item tb">
                    <span class="detail-order-item-t"><i class="fa fa-location-arrow"></i> Địa chỉ nhận</span>
                    <p class="detail-order-item-b"><?php echo $result_order['address'] ?></p>
                </li>
            </ul>
        </div>
    </div>
    <div class="modal-detail-bottom">
        <div class="modal-detail-bottom-left">
            <div class="price-total">
                <span class="thanhtien">Thành tiền</span>
                <span class="price">$<?php echo $result_order['total_price']; ?></span>
            </div>
        </div>
        <div class="modal-detail-bottom-right">
            <form method="POST">
                <?php
                if ($result_order['payment_status'] == "pending") {
                ?>


                    <button class="btn-chuaxuly modal-detail-btn"><?php echo $result_order['payment_status'] ?></button>
                </form>
                <?php
                } else {
                ?>
                </form>
                    <button class="btn-daxuly modal-detail-btn"><?php echo $result_order['payment_status'] ?></button>

            <?php
                }
            }
            ?>
        </div>
    </div>

    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bắt sự kiện click cho nút "Chưa xử lý"
            var btnChuaXuLy = document.querySelector('.btn-chuaxuly');
            if (btnChuaXuLy) {
                btnChuaXuLy.addEventListener('click', function() {
                    var orderId = <?php echo $order_id; ?>; // Lấy orderId từ PHP
                    // Gửi yêu cầu AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'update_payment_status.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Xử lý phản hồi từ máy chủ
                            var response = xhr.responseText;
                            if (response == 'success') {
                            } else {
                                // Xử lý lỗi nếu có
                                console.log('Có lỗi xảy ra: ' + response);
                            }
                        }
                    };
                    xhr.send('order_id=' + orderId);
                });
            }
        });
    </script>
</body>

</html>