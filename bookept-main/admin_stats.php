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
    </div>
    </div>
    <div id="toast"></div>
    <script src="js/admin.js"></script>
</body>

</html>