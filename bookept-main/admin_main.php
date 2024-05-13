<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('Location:login_admin.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $insert_query = "INSERT INTO users (name, email, password, user_type, phone_number) VALUES ('$name', '$email', '$password', '$user_type', '$phone_number')";
    header('Location: admin_main.php');
    exit();
}
//search
// if (isset($_GET['submit_search'])) 
// {
//     $search=$_GET['text_search'];
//     $sql_tk="SELECT * FROM users WHERE name LIKE '%" . $search . "%'";
//     $sql_search= mysqli_query($conn,$sql_tk);
// }
// else
// {
//     $search='';
//     $sql_tk="SELECT* FROM users limit 5";
//     $sql_search= mysqli_query($conn,$sql_tk);

// }
// xóa 

if (isset($_GET['delete'])) // kiểm tra xem có tồn tại tham số 'delete' trong mảng $_GET hay không nếu có gì có id
{
    $delete_id = $_GET['delete']; // nếu có thì lấy id 
    mysqli_query($conn, "DELETE FROM users WHERE id = '$delete_id'") or die('query failed');
}
if (isset($_GET['block'])) {
    $block_id = $_GET['block'];
    $sql_block = mysqli_query($conn, "SELECT * FROM  users WHERE id=$block_id");
    if (mysqli_num_rows($sql_block) > 0) {
        $query = "UPDATE users SET status = 0 WHERE id = $block_id";
    }
}
if (isset($_GET['block'])) {
    $block_id = $_GET['block'];
    $sql_block = mysqli_query($conn, "SELECT * FROM  users WHERE id=$block_id");
    if (mysqli_num_rows($sql_block) > 0) {
        $query = "UPDATE users SET status = 0 WHERE id = $block_id";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Người dùng đã được chặn.');</script>";
        } else {
            echo "Cập nhật trạng thái thất bại: " . mysqli_error($conn);
        }
    }
}
if (isset($_GET['unblock'])) {
    $unblock_id = $_GET['unblock'];
    $sql_unblock = mysqli_query($conn, "SELECT * FROM  users WHERE id=$unblock_id");
    if (mysqli_num_rows($sql_unblock) > 0) {
        $query = "UPDATE users SET status = 1 WHERE id = $unblock_id";
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
                    <li id="main" class="sidebar-list-item tab-content active">
                        <a href="admin_main.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-home"></i></div>
                            <div class="hidden-sidebar">Overview </div>
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
                    <li class="sidebar-list-item tab-content">
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
                        <a href="#" class="sidebar-link">
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
            <div class="section active">
                <h1 class="page-title">Over view of Bookept store</h1>
                <div class="cards">
                    <div class="card-single">
                        <div class="box">
                            <?php
                            $select_users = mysqli_query($conn, "SELECT * FROM users WHERE user_type = 'user'") or die('query failed');
                            $number_of_users = mysqli_num_rows($select_users);
                            ?>
                            <h2><?php echo $number_of_users; ?></h2>
                            <div class="on-box">
                                <img src="" alt="" style=" width: 200px;">
                                <h3>Customer</h3>
                                
<p>A product is anything that can be brought to the market to attract attention, be purchased, used, or consumed to satisfy a need or desire. It can be objects, services, people, places, organizations, or an idea.</p>
                            </div>

                        </div>
                    </div>
                    <div class="card-single">
                        <div class="box">
                            <div class="on-box">
                                <img src="" alt="" style=" width: 200px;">
                                <?php
                                $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
                                $number_of_products = mysqli_num_rows($select_products);
                                ?>
                                <h2><?php echo $number_of_products; ?></h2>
                                <h3>Products</h3>
                                <p>A target customer is a group of customer segments within the target market that your business is aiming at.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-single">
                        <div class="box">
                            <?php
                            $total_pendings = 0;
                            $select_pending = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status = 'pending'") or die('query failed');
                            if (mysqli_num_rows($select_pending) > 0) {
                                while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                                    $total_price = $fetch_pendings['total_price'];
                                    $total_pendings += $total_price;
                                }
                            }
                            ?>
                            <h2>$<?php echo $total_pendings; ?>/-</h2>
                            <?php
                            ?>
                            <div class="on-box">
                                <img src="" alt="" style=" width: 200px;">
                                <h3>Revenue</h3>
                                <p>The revenue of a business is the total amount of money it will receive from the consumption of products or the provision of services at a certain volume.</p>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/admin.js"></script>
</body>

</html>