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
                        <a style="color:white" href="admin_stats.php"><button class="btn-control-large">Back</button></a>
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
                            } else {
                                $name = $_GET['customer_name'];
                                $select_orders = mysqli_query($conn, "SELECT * FROM orders WHERE payment_status = 'Completed' AND name = '$name'") or die('query failed');
                                if (mysqli_num_rows($select_orders) > 0) {
                                    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $fetch_orders['placed_on'] ?></td>
                                            <td><?php echo $fetch_orders['method'] ?></td>
                                            <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                            <td class="control"><a style="color:black" href="admin_stats_popup.php?customer_name=<?php echo $fetch_orders['name'] ?> &order_id=<?php echo $fetch_orders['id'] ?>"><button class="btn-detail"><i class=" fa fa-asterisk"></i>Details</button></a></td>

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