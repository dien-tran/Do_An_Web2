<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('Location:login.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $insert_query = "INSERT INTO `users` (name, email, password, user_type, phone_number) VALUES ('$name', '$email', '$password', '$user_type', '$phone_number')";
    header('Location: admin.php');
    exit();
}
//search
// if (isset($_GET['submit_search'])) 
// {
//     $search=$_GET['text_search'];
//     $sql_tk="SELECT * FROM `users` WHERE `name` LIKE '%" . $search . "%'";
//     $sql_search= mysqli_query($conn,$sql_tk);
// }
// else
// {
//     $search='';
//     $sql_tk="SELECT* FROM `users` limit 5";
//     $sql_search= mysqli_query($conn,$sql_tk);

// }
// xóa 

if (isset($_GET['delete'])) // kiểm tra xem có tồn tại tham số 'delete' trong mảng $_GET hay không nếu có gì có id
{
    $delete_id = $_GET['delete']; // nếu có thì lấy id 
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
}
if (isset($_GET['block'])) {
    $block_id = $_GET['block'];
    $sql_block = mysqli_query($conn, "SELECT * FROM  `users` WHERE id=$block_id");
    if (mysqli_num_rows($sql_block) > 0) {
        $query = "UPDATE `users` SET `status` = 0 WHERE id = $block_id";
    }
}
if (isset($_GET['block'])) {
    $block_id = $_GET['block'];
    $sql_block = mysqli_query($conn, "SELECT * FROM  `users` WHERE id=$block_id");
    if (mysqli_num_rows($sql_block) > 0) {
        $query = "UPDATE `users` SET `status` = 0 WHERE id = $block_id";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Người dùng đã được chặn.');</script>";
        } else {
            echo "Cập nhật trạng thái thất bại: " . mysqli_error($conn);
        }
    }
}
if (isset($_GET['unblock'])) {
    $unblock_id = $_GET['unblock'];
    $sql_unblock = mysqli_query($conn, "SELECT * FROM  `users` WHERE id=$unblock_id");
    if (mysqli_num_rows($sql_unblock) > 0) {
        $query = "UPDATE `users` SET `status` = 1 WHERE id = $unblock_id";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Người dùng đã gỡ chặn.');</script>";
        } else {
            echo "Cập nhật trạng thái thất bại: " . mysqli_error($conn);
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
                        <a href="#" class="sidebar-link" id="logout-acc">
                            <div class="sidebar-icon"><i class="fa fa-arrow-right"></i></div>
                            <div class="hidden-sidebar">Đăng xuất</div>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="content">
            <div class="section active">
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

                            <p class="order-statistical-item-content-desc">Sản phẩm được bán nhiều nhất</p>
                            <?php $most_sold = mysqli_query($conn, "SELECT p.Name AS ProductName, SUM(db.ProductAmount) AS TotalSold FROM detailsbill db INNER JOIN products p ON db.IdProduct = p.Id GROUP BY db.IdProduct ORDER BY TotalSold DESC LIMIT 3");
                            if(mysqli_num_rows($most_sold) > 0)
                            {
                                $i = 1;
                                while ($fetch_sold = mysqli_fetch_assoc($most_sold)) 
                                {
                                    echo '<h4 class="order-statistical-item-content-h">#'.$i++.' '.$fetch_sold['name'].'</h4>';
                                }
                            }
                            ?>
                        </h4>
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
                                $sql_product_image = mysqli_query($conn, "SELECT * FROM products WHERE Name = '$product_name'");
                                $product_img_data = mysqli_fetch_assoc($sql_product_image);
                                $product_img_url = $product_img_data['Image'];

                                // Truy vấn cơ sở dữ liệu để lấy thông tin về sản phẩm
                                $sql_product = mysqli_query($conn, "SELECT * FROM products WHERE Name = '$product_name'");
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
            <!-- <button name="cancel" style="background-color: red;" class="btn-cancel modal-detail-btn" <?php if($result_order['payment_status'] == 'Completed'){
                 echo 'style="cursor: not-allowed;';} ?>>Cancel</button> -->
                <button name="cancel" class="btn-cancel modal-detail-btn" <?php if($result_order['payment_status'] == 'Completed' || $result_order['payment_status'] == "Cancel")
                 echo 'style="cursor: not-allowed;"';?>>Cancel</button>
                <?php
                if ($result_order['payment_status'] == "pending") {
                ?>
            

                    <button name="payment" class="btn-chuaxuly modal-detail-btn"><?php echo $result_order['payment_status'] ?></button>
                </form>
                <?php
                } elseif($result_order['payment_status'] == "Completed") {
                ?>
                    
                    <button style="cursor: not-allowed;" name="payment" class="btn-daxuly modal-detail-btn"><?php echo $result_order['payment_status'] ?></button>
                    </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
    </div>
    </div>
    <div id="toast"></div>
    <script src="js/admin.js"></script>
</body>

</html>