<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('Location:login.php');
    exit();
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
                    <li class="sidebar-list-item tab-content">
                        <a href="admin_orders.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-shopping-cart"></i></div>
                            <div class="hidden-sidebar">Order</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content active">
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
                <div class="admin-control">
                    <div class="admin-control-right">
                        <form method="post" class="fillter-date">
                            <button class="btn-control-large"><a style="color:white" href="admin_stats.php">Back</a></button>
                        </form>
                    </div>
                </div>
                <div class="order-statistical" id="order-statistical">

                    <div class="order-statistical-item">
                    <div class="order-statistical-item-content">
                        <p class="order-statistical-item-content-desc"><?php $name = $_GET['customer_name']; 
                        echo $name?>'s revenue</p>
                            <h4 class="order-statistical-item-content-h" id="quantity-sale">
                                <?php
                                $total_pendings = 0;
                                
                                $select_pending = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status = 'Completed' AND name = '$name'") or die('query failed');
                                if (mysqli_num_rows($select_pending) > 0) {
                                    while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                                        $total_price = $fetch_pendings['total_price'];
                                        $total_pendings += $total_price;
                                    }
                                }
                                echo $total_pendings . "$";
                                ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>Order date</td>
                                <td>Phone</td>
                                <td>Revenue</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody id="showTk">
                            <?php
                            if (isset($_GET['start_date'])) {
                                $name = $_GET['customer_name'];
                                $start_date = $_GET['start_date'];
                                $end_date = $_GET['end_date'];
                                $select_orders = mysqli_query($conn, "SELECT * FROM orders WHERE payment_status = 'Completed' AND name = '$name' AND placed_on BETWEEN '$start_date' AND '$end_date'") or die('query failed');
                                if (mysqli_num_rows($select_orders) > 0) {
                                    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                            ?>
                                        <tr>
                                            <td><?php echo $fetch_orders['placed_on'] ?></td>
                                            <td><?php echo $fetch_orders['method'] ?></td>
                                            <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                            <td class="control"><a style="color:black" href="admin_stats_popup.php?customer_name=<?php echo $fetch_orders['name'] ?> &order_id=<?php echo $fetch_orders['id'] ?>&start_date=<?php echo $start_date ?>&end_date=<?php echo $end_date ?>"><button class="btn-detail"><i class=" fa fa-asterisk"></i>Details</button></a></td>

                                        </tr>
                                    <?php
                                    }
                                }
                            } elseif (isset($_GET['customer_name'])) {
                                $name = $_GET['customer_name'];
                                $select_orders = mysqli_query($conn, "SELECT * FROM orders WHERE name = '$name' AND payment_status = 'Completed'") or die('query failed');
                                if (mysqli_num_rows($select_orders) > 0) {
                                    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $fetch_orders['placed_on'] ?></td>
                                            <td><?php echo $fetch_orders['method'] ?></td>
                                            <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                            <td class="control"><a style="color:black" href="admin_stats_popup.php?order_id=<?php echo $fetch_orders['id'] ?>"><button class="btn-detail"><i class=" fa fa-asterisk"></i>Details</button></a></td>

                                        </tr>
                            <?php
                                    }
                                }
                            }


                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <div class="modal detail-order open" id="a">
            <div class="modal-container">
                <h3 class="modal-container-title">Order Details</h3>
                <form name="form" action="" method="post">
                    <input type="hidden" id="order_id_input" name="order_id">
                </form>
                <?php
                // Lấy order_id từ tham số GET
                $order_id = $_GET['order_id'];

                // Truy vấn để lấy thông tin đơn hàng từ CSDL
                $sql_order = mysqli_query($conn, "SELECT * FROM orders where id = '$order_id' ");
                $result_order = mysqli_fetch_assoc($sql_order);

                // Kiểm tra xem có đơn hàng nào được tìm thấy không
                if ($result_order) {
                ?>
                    <div class="modal-detail-order">
                        <?php
                        if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                            $start_date = $_GET['start_date'];
                            $end_date = $_GET['end_date'];
                        ?>
                            <a href="admin_stats_details.php?customer_name=<?php echo $result_order['name'] ?>&start_date=<?php echo $start_date ?>&end_date=<?php echo $end_date ?>"><button class="modal-close"><i class="fa fa-close"></i></button></a>
                        <?php
                        } else {
                        ?>
                            <a href="admin_stats_details.php?customer_name=<?php echo $result_order['name'] ?>"><button class="modal-close"><i class="fa fa-close"></i></button></a>
                        <?php
                        }
                        ?>
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
                    <?php
                                } ?>
                    </div>
            </div>
            <div class="modal-detail-right">
                <ul class="detail-order-group">
                    <li class="detail-order-item">
                        <span class="detail-order-item-left"><i class="fa fa-calendar"></i> Order date</span>
                        <span class="detail-order-item-right"><?php echo $result_order['placed_on']; ?></span>
                    </li>
                    <li class="detail-order-item">
                        <span class="detail-order-item-left"><i class="fa fa-user"></i> Customer</span>
                        <span class="detail-order-item-right"><?php echo $result_order['name'] ?></span>
                    </li>
                    <li class="detail-order-item">
                        <span class="detail-order-item-left"><i class="fa fa-phone"></i> Phone</span>
                        <span class="detail-order-item-right"><?php echo $result_order['number'] ?></span>
                    </li>
                    <li class="detail-order-item tb">
                        <span class="detail-order-item-t"><i class="fa fa-location-arrow"></i> Address</span>
                        <p class="detail-order-item-b"><?php echo $result_order['address'] ?></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal-detail-bottom">
            <div class="modal-detail-bottom-left">
                <div class="price-total">
                    <span class="thanhtien">Total Price</span>
                    <span class="price">$<?php echo $result_order['total_price']; ?></span>
                </div>
            </div>
            <div class="modal-detail-bottom-right">
            <?php
                }
            ?>
            </div>
        </div>
    </div>
    </div>
    <div id="toast"></div>
    <script>
        const closeModalBtn = document.querySelector('.modal-close');

        // Add an event listener to the close button
        closeModalBtn.addEventListener('click', function() {
            // Get the modal element
            const modal = document.querySelector('.modal.detail-order');

            // Remove the "open" class from the modal
            modal.classList.remove('open');
        });
    </script>
</body>

</html>