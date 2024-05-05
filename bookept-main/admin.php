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

if(isset($_GET['delete']))// kiểm tra xem có tồn tại tham số 'delete' trong mảng $_GET hay không nếu có gì có id
{
    $delete_id = $_GET['delete'];// nếu có thì lấy id 
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   
}
if (isset($_GET['block']))
{
    $block_id = $_GET['block'];
    $sql_block=mysqli_query($conn , "SELECT * FROM  `users` WHERE id=$block_id");
    if(mysqli_num_rows($sql_block)>0)
    {
        $query = "UPDATE `users` SET `status` = 0 WHERE id = $block_id";
    }
    
}
if (isset($_GET['block']))
{
    $block_id = $_GET['block'];
    $sql_block=mysqli_query($conn , "SELECT * FROM  `users` WHERE id=$block_id");
    if(mysqli_num_rows($sql_block)>0)
    {
        $query = "UPDATE `users` SET `status` = 0 WHERE id = $block_id";
        if (mysqli_query($conn, $query)) 
        {
            echo "<script>alert('Người dùng đã được chặn.');</script>";
        } 
        else 
        {
            echo "Cập nhật trạng thái thất bại: " . mysqli_error($conn);
        }
    }
    
}
if (isset($_GET['unblock']))
{
    $unblock_id = $_GET['unblock'];
    $sql_unblock=mysqli_query($conn , "SELECT * FROM  `users` WHERE id=$unblock_id");
    if(mysqli_num_rows($sql_unblock)>0)
    {
        $query = "UPDATE `users` SET `status` = 1 WHERE id = $unblock_id";
        if (mysqli_query($conn, $query)) 
        {
            echo "<script>alert('Người dùng đã gỡ chặn.');</script>";
        } 
        else 
        {
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
                    <li class="sidebar-list-item tab-content active">
                        <a href="#" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-home"></i></div>
                            <div class="hidden-sidebar"> rang tổng quan</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content">
                        <a href="#" class="sidebar-link">
                            <div class="sidebar-icon]"><i class="fa fa-book"></i></div>
                            <div class="hidden-sidebar">Sản phẩm</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content">
                        <a href="#" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-group"></i></div>
                            <div class="hidden-sidebar">Khách hàng</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content">
                        <a href="#" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-shopping-cart"></i></div>
                            <div class="hidden-sidebar">Đơn hàng</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content">
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
                        <a href="index.html" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-home"></i></div>
                            <div class="hidden-sidebar">Trang chủ</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item user-logout">
                        <a href="#" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-user"></i></div>
                            <div class="hidden-sidebar" id="name-acc"></div>
                        </a>
                    </li>
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
                <h1 class="page-title">Trang tổng quát của cửa hàng Goodbookclub</h1>
                <div class="cards">
                    <div class="card-single">
                        <div class="box">
                            <?php
                            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
                            $number_of_users = mysqli_num_rows($select_users);
                            ?>
                            <h2><?php echo $number_of_users; ?></h2>
                            <div class="on-box">
                                <img src="" alt="" style=" width: 200px;">
                                <h3>Khách hàng</h3>
                                <p>Sản phẩm là bất cứ cái gì có thể đưa vào thị trường để tạo sự chú ý, mua sắm, sử dụng
                                    hay tiêu dùng nhằm thỏa mãn một nhu cầu hay ước muốn. Nó có thể là những vật thể,
                                    dịch vụ, con người, địa điểm, tổ chức hoặc một ý tưởng.</p>
                            </div>

                        </div>
                    </div>
                    <div class="card-single">
                        <div class="box">
                            <div class="on-box">
                                <img src="" alt="" style=" width: 200px;">
                                <?php
                                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                                $number_of_products = mysqli_num_rows($select_products);
                                ?>
                                <h2><?php echo $number_of_products; ?></h2>
                                <h3>Sản phẩm</h3>
                                <p>Khách hàng mục tiêu là một nhóm đối tượng khách hàng trong phân khúc thị trường mục
                                    tiêu mà doanh nghiệp bạn đang hướng tới. </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-single">
                        <div class="box">
                            <?php
                            $total_pendings = 0;
                            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
                            if (mysqli_num_rows($select_pending) > 0) {
                                while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                                    $total_price = $fetch_pendings['total_price'];
                                    $total_pendings += $total_price;
                                };
                            };
                            ?>
                            <h2>$<?php echo $total_pendings; ?>/-</h2>
                            <div class="on-box">
                                <img src="" alt="" style=" width: 200px;">
                                <h3>Doanh thu</h3>
                                <p>Doanh thu của doanh nghiệp là toàn bộ số tiền sẽ thu được do tiêu thụ sản phẩm, cung
                                    cấp dịch vụ với sản lượng.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product  -->
            <div class="section product-all">
                <div class="admin-control">
                    <div class="admin-control-left">
                        <select name="the-loai" id="the-loai" onchange="showProduct()">
                            <option>Tất cả</option>
                            <option>Tiểu thuyết</option>
                            <option>Truyện ngắn</option>
                            <option>Self Help</option>
                            <option>Kinh dị</option>
                            <option>Đã xóa</option>
                        </select>
                    </div>
                    <div class="admin-control-center">
                        <form action="" class="form-search">
                            <span class="search-btn"><i class="fa fa-search"></i></span>
                            <input id="form-search-product" type="text" class="form-search-input" placeholder="Tìm kiếm tên sách..." oninput="showProduct()">
                        </form>
                    </div>
                    <div class="admin-control-right">
                        <button class="btn-control-large" id="btn-cancel-product" onclick="cancelSearchProduct()"><i class="fa fa-refresh fa-spin"></i> Làm mới</button>
                        <button class="btn-control-large" id="btn-add-product"><i class="fa fa-plus"></i> Thêm sách mới</button>
                    </div>
                </div>
                <div id="show-product">
                    <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    ?>
                            <div class="list">
                                <div class="list-left">
                                    <img src="<?php echo $fetch_products['Image']?>" alt="">
                                    <div class="list-info">
                                        <h4><?php echo $fetch_products['Name']?></h4>
                                        <p class="list-note"><?php echo $fetch_products['Description']?></p>
                                        <span class="list-category">${product.category}</span>
                                    </div>
                                </div>
                                <div class="list-right">
                                    <div class="list-price">
                                        <span class="list-current-price"><?php echo $fetch_products['Price'] ?></span>
                                    </div>
                                    <div class="list-control">
                                        <div class="list-tool">
                                            <!-- <button class="btn-edit" onclick="editProduct(${product.id})"><i class="fa fa-pencil"></i></button> -->
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<p class="empty">no products added yet!</p>';
                    }
                    ?>
                </div>
                <div class="page-nav">
                    <ul class="page-nav-list">
                    </ul>
                </div>
            </div>
            <!-- Account  -->
            <div class="section">
                <div class="admin-control">
                    <!-- <div class="admin-control-left">
                        <select name="tinh-trang-user" id="tinh-trang-user" onchange="showUser()">
                            <option value="2">Tất cả</option>
                            <option value="1">Hoạt động</option>
                            <option value="0">Bị khóa</option>
                        </select>
                    </div> -->
                    <div class="admin-control-center">
                        <form action="#?" class="form-search" method="GET">
                            <span class="search-btn"><i class="fa fa-search"></i></span>
                            <!-- <input id="form-search-user" type="text" class="form-search-input" placeholder="Tìm kiếm khách hàng..." oninput="showUser()"> -->
                            <input id="form-search-user" type="text"name ="text_search" class="form-search-input" placeholder="Tìm kiếm khách hàng...">
                            <button id="btn-add-user" class="btn-control-large" type="submit" name="submit_search"> Tìm kiếm </button>
                        </form>  
                    </div>
                    
                    <div class="admin-control-right">
                        <!-- <form action="" class="fillter-date">
                            <div>
                                <label for="time-start">Từ</label>
                                <input type="date" class="form-control-date" id="time-start-user" onchange="showUser()">
                            </div>
                            <div>
                                <label for="time-end">Đến</label>
                                <input type="date" class="form-control-date" id="time-end-user" onchange="showUser()">
                            </div>
                        </form> -->
                        <!-- <button class="btn-reset-order" onclick="cancelSearchUser()"><i class="fa fa-refresh fa-spin"></i></button> -->
                        <button id="btn-add-user" class="btn-control-large" onclick="register()"><i class="fa fa-plus"></i> <span>Thêm khách hàng</span></button>
                        <script> // chuyển sang trang register . khi thêm khách hàng
                            function register()
                            {
                                window.location.href="register.php";
                                // window.location.href="admin.php"; đang ghi đè nên không thành côngh

                            }
                        </script>
                        
                    </div>
                </div>
                <?php
if (isset($_GET['submit_search'])) 
{
    $search = $_GET['text_search'];
    if (!empty($search)) {
        $sql_tk = "SELECT * FROM `users` WHERE `name` LIKE '%" . $search . "%'";
        $sql_search = mysqli_query($conn, $sql_tk);
        if (mysqli_num_rows($sql_search) > 0) {
            ?>
            <table width="100%">
                <thead>
                    <tr>
                        <td>Họ và tên</td>
                        <td>Liên hệ</td>
                        <td>Ngày tham gia</td>
                    </tr>
                </thead>
                <tbody id="show-user">
                    <?php
                    while ($fetch_users = mysqli_fetch_assoc($sql_search)) 
                    {   if($fetch_users['user_type']=="user")
                        {
                        ?>
                        <tr>
                            <td><?php echo $fetch_users['name']; ?></td>
                            <td><?php echo $fetch_users['phone_number']; ?></td>
                            <td><?php echo $fetch_users['date_time']; ?></td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "Không tìm thấy thông tin.";
        }
    } else {
        echo "Vui lòng nhập từ khóa tìm kiếm.";
    }
}
else {
    $search='';
    $sql_tk="SELECT * FROM `users` LIMIT 5";
    $sql_search= mysqli_query($conn,$sql_tk);
}
?>
                <!-- thong tin nguoi dung -->
                <div class="table">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>STT </td>
                                <td>Họ và tên</td>
                                <td>Liên hệ</td>
                                <td>Ngày tham gia</td>
                                <td>Chức năng</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody id="show-user">
                            <?php
                                
                               $select_users = mysqli_query($conn, "SELECT * FROM  `users`");
                                
                                $stt=1;
                                while ($fetch_users =mysqli_fetch_assoc($select_users))
                                {
                                        if ($fetch_users['user_type']=='user')
                                        {
                                        ?>

                                        <tr>
                                            <td><?php echo $stt ?></td>
                                            <td><?php echo $fetch_users['name']; ?></td>
                                            <td><?php echo $fetch_users['phone_number']; ?></td>
                                            <td><?php echo $fetch_users['date_time']; ?></td>
                                            <td>
                                                <form method="GET">
                                                <?php 
                                                    if ($fetch_users['status'] == 1) 
                                                    { 
                                                        ?>
                                                        <a id="btn-add-user" class="btn-control-large" type="submit" name="delete" href="admin.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">Xóa</a>
                                                        <a id="btn-add-user" class="btn-control-large" type="submit" name="block" href="admin.php?block=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Block this user?');" class="delete-btn">Chặn</a>
                                                        <?php 
                                                    } 
                                                    else 
                                                    { 
                                                        ?>
                                                        <a id="btn-add-user" class="btn-control-large" type="submit" name="delete" href="admin.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">Xóa</a>
                                                        <a id="btn-add-user" class="btn-control-large" type="submit" name="unblock" href="admin.php?unblock=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Unblock this user?');" class="delete-btn">Gỡ chặn</a>
                                                        <?php 
                                                    } 
                                                ?>
                                            </td>
                                           
                                        </tr>
                                        <?php
                                        }

                                    $stt++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- </div> -->
            </div>
            <!-- Order  -->
            <div class="section">
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
    <div class="modal add-product">
        <div class="modal-container">
            <h3 class="modal-container-title add-product-e">THÊM MỚI SẢN PHẨM</h3>
            <h3 class="modal-container-title edit-product-e">CHỈNH SỬA SẢN PHẨM</h3>
            <button class="modal-close product-form"><i class="fa fa-times"></i></button>
            <div class="modal-content">
                <form action="" class="add-product-form">
                    <div class="modal-content-left">
                        <img src="./image/" alt="" class="upload-image-preview">
                        <div class="form-group file">
                            <label for="up-hinh-anh" class="form-label-file"><i class="fa fa-plus"></i>Chọn hình ảnh</label>
                            <input accept="image/jpeg, image/png, image/jpg" id="up-hinh-anh" name="up-hinh-anh" type="file" class="form-control" onchange="uploadImage(this)">
                        </div>
                    </div>
                    <div class="modal-content-right">
                        <div class="form-group">
                            <label for="ten-mon" class="form-label">Tên sách</label>
                            <input id="ten-mon" name="ten-mon" type="text" placeholder="Nhập tên sách" class="form-control">
                            <span class="form-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="category" class="form-label">Chọn thể loại</label>
                            <select name="category" id="chon-mon">
                                <option>Tiểu thuyết</option>
                                <option>Truyện ngắn</option>
                                <option>Kinh dị</option>
                                <option>Self Help</option>
                            </select>
                            <span class="form-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="gia-moi" class="form-label">Giá bán</label>
                            <input id="gia-moi" name="gia-moi" type="text" placeholder="Nhập giá bán" class="form-control">
                            <span class="form-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="mo-ta" class="form-label">Mô tả</label>
                            <textarea class="product-desc" id="mo-ta" placeholder="Nhập mô tả sách..."></textarea>
                            <span class="form-message"></span>
                        </div>
                        <button class="form-submit btn-add-product-form add-product-e" id="add-product-button">
                            <i class="fa fa-plus"></i>
                            <span>THÊM SÁCH</span>
                        </button>
                        <button class="form-submit btn-update-product-form edit-product-e" id="update-product-button">
                            <i class="fa fa-floppy-o"></i>
                            <span>LƯU THAY ĐỔI</span>
                        </button>
                    </div>
                </form>
            </div>
            </form>
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