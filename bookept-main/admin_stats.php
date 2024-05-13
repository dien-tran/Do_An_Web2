<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('Location:login_admin.php');
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
                        <a href="#" class="sidebar-link" id="logout-acc">
                            <div class="sidebar-icon"><i class="fa fa-arrow-right"></i></div>
                            <div class="hidden-sidebar" onclick="redirectToLogout()">Log out</div>
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
                            <div>
                                <label for="start_date">From:</label>
                                <input class="form-control-date" type="date" id="start_date" name="start_date">
                            </div>
                            <div>
                                <label for="end_date">To:</label>
                                <input class="form-control-date" type="date" id="end_date" name="end_date">
                            </div>
                            <button class="btn-control-large" type="submit" name="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="order-statistical" id="order-statistical">
                    <div class="order-statistical-item">
                        <div class="order-statistical-item-content">
                            <p class="order-statistical-item-content-desc">Revenue</p>
                            <h4 class="order-statistical-item-content-h" id="quantity-sale">
                                <?php
                                $total_pendings = 0;
                                $select_pending = mysqli_query($conn, "SELECT total_price FROM orders WHERE payment_status = 'Completed'") or die('query failed');
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
                        <div class="order-statistical-item-icon">
                            <i class=""></i>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>Customer</td>
                                <td>Order date</td>
                                <td>Phone</td>
                                <td>Revenue</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody id="showTk">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                                
                                // Retrieve start and end date from the form
                                $start_date = $_POST['start_date'];
                                $end_date = $_POST['end_date'];
                                // Retrieve orders within the specified time range
                                $select_orders = mysqli_query($conn, "SELECT * FROM orders WHERE placed_on BETWEEN '$start_date' AND '$end_date' ORDER BY total_price DESC LIMIT 0, 5") or die('query failed');
                                if(mysqli_num_rows($select_orders) > 0)
                                {
                                    while($fetch_orders = mysqli_fetch_assoc($select_orders))
                                    {
                                        ?>
                                            <td><?php echo $fetch_orders['name'] ?></td>
                                            <td><?php echo $fetch_orders['placed_on'] ?></td>
                                            <td><?php echo $fetch_orders['number'] ?></td>
                                            <td>$<?php echo $fetch_orders['total_price'] ?></td>
                                            <td class="control">
                                                <form method="post">
                                                    <a style="color:black" href="admin_stats_details.php?start_date= <?php echo $start_date?>&end_date=<?php echo $end_date ?>&order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i>Details</a>
                                                </form>
                                    </tr>
                                        <?php
                                    }
                                }
                                // Array to store customer total purchases
                                // Process each order
                                // while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                //     // Calculate total purchase amount for each order
                                //     $total_price = $fetch_orders['total_price'];
                                //     $customer_id = $fetch_orders['user_id'];
                                //     $customer_orders_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $customer_id AND placed_on BETWEEN '$start_date' AND '$end_date'");
                                // }
                                }
                                elseif (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                                    $start_date = $_GET['start_date'];
                                    $end_date = $_GET['end_date'];
                                    $select_orders = mysqli_query($conn, "SELECT * FROM orders WHERE placed_on BETWEEN '$start_date' AND '$end_date' ORDER BY total_price DESC LIMIT 0, 5") or die('query failed');
                                    if (mysqli_num_rows($select_orders) > 0) {
                                        while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                                            ?>
                                            <td><?php echo $fetch_orders['name'] ?></td>
                                            <td><?php echo $fetch_orders['placed_on'] ?></td>
                                            <td><?php echo $fetch_orders['number'] ?></td>
                                            <td>$<?php echo $fetch_orders['total_price'] ?></td>
                                            <td class="control">
                                                <form method="post">
                                                    <a style="color:black" href="admin_stats_details.php?start_date= <?php echo $start_date ?>&end_date=<?php echo $end_date ?>&order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Details</a>
                                                </form>
                                                </tr>
                                            <?php
                                        }
                                    }
                                 } else {
                                $select_orders = mysqli_query($conn, "SELECT * FROM orders") or die('query failed');
                                if (mysqli_num_rows($select_orders) > 0) {
                                    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                            ?>
                                        <tr>
                                            <td><?php echo $fetch_orders['name'] ?></td>
                                            <td><?php echo $fetch_orders['placed_on'] ?></td>
                                            <td><?php echo $fetch_orders['number'] ?></td>
                                            <td><?php echo $fetch_orders['total_price'] ?>$</td>
                                            <td class="control">
                                                <form method="post">
                                                    <a style="color:black" href="admin_stats_details.php?order_id=<?php echo $fetch_orders['id']; ?>"><i class=" fa fa-asterisk"></i> Chi tiết</a>
                                                </form>
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
    <script src="js/admin.js"></script>
</body>

</html>