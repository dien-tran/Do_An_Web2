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
   $insert_query = "INSERT INTO users (name, email, password, user_type, phone_number) VALUES ('$name', '$email', '$password', '$user_type', '$phone_number')";
   header('Location: admin.php');
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
         echo "<script>alert('User has been blocked.');</script>";
      } else {
         echo "Update failed: " . mysqli_error($conn);
      }
   }
}
if (isset($_GET['unblock'])) {
   $unblock_id = $_GET['unblock'];
   $sql_unblock = mysqli_query($conn, "SELECT * FROM  users WHERE id=$unblock_id");
   if (mysqli_num_rows($sql_unblock) > 0) {
      $query = "UPDATE users SET status = 1 WHERE id = $unblock_id";
      if (mysqli_query($conn, $query)) {
         echo "<script>alert('User has been unblocked.');</script>";
      } else {
         echo "Update failed: " . mysqli_error($conn);
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
                    <li id="customers" class="sidebar-list-item tab-content active">
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
         <!-- Account  -->
         <div class="section active">
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
                     <!-- <input id="form-search-user" type="text" class="form-search-input" placeholder="search..."> -->
                     <input id="form-search-user" type="text" name="text_search" class="form-search-input" placeholder="Search for username..."value="<?php echo isset($_GET['text_search']) ? $_GET['text_search'] : ''; ?>">
                     <button id="btn-search-user" class="btn-control-large" type="submit" name="submit_search"> Search </button>
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
                  <button id="btn-add-user" class="btn-control-large" onclick="register()"><i class="fa fa-plus"></i> <span>Add a customer</span></button>
                  <script>
                     // chuyển sang trang register . khi thêm khách hàng
                     function register() {
                        window.location.href = "addcustomer.php";
                        // window.location.href="admin.php"; đang ghi đè nên không thành côngh

                     }
                  </script>

               </div>
            </div>
            <?php
            $search_keyword = isset($_GET['text_search']) ? $_GET['text_search'] : '';
            // Define default SQL query to fetch all users
            $sql_tk = "SELECT * FROM users WHERE user_type = 'user' AND Name LIKE '%$search_keyword%'";
            // Default SQL query to fetch all users      
            // $sql_search = mysqli_query($conn, $sql_tk);
            $products_per_page = 8; // số lượng hiển thị trên 1 trang
            $total_users = mysqli_num_rows(mysqli_query($conn, $sql_tk));
            $total_pages = ceil($total_users / $products_per_page);
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            // Tính offset (bắt đầu lấy từ vị trí nào trong cơ sở dữ liệu)
            $offset = ($current_page - 1) * $products_per_page;
            // $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT $offset, $products_per_page") or die('query failed');
            $select_products = mysqli_query($conn, $sql_tk . " LIMIT $offset, $products_per_page") or die('query failed');
            $stt = 1;
            $pagee=1;


            // $sql_page = mysqli_query($conn, "SELECT * FROM `users`");

            // Check if search form is submitted
            // if (isset($_GET['submit_search'])) 
            // {
            //    $search = $_GET['text_search'];
            //    // Modify the SQL query to include search functionality
            //     $sql_tk .= " WHERE name LIKE '%" . $search . "%'";
            //     $sql_search = mysqli_query($conn, $sql_tk);
            //    $row_count = mysqli_num_rows($sql_search);
            //    $max = ceil($row_count / $products_per_page); // Tính lại số lượng trang dựa trên kết quả tìm kiếm

            // }
            // else
            // {
            //    $row_count = mysqli_num_rows($sql_page);
            //     $max = ceil($row_count / $products_per_page); // tìm tổng số lượng trang

            // }
            // Calculate pagination variables
            //    $start = 1;
            //       // Kiểm tra và lấy giá trị của tham số 'page'
            //    $pagee = isset($_GET['page']) ? $_GET['page'] : 1;
            //    if ($pagee == "" || $pagee == 1) 
            //    {
            //        $begin = 0;
            //    } 
            //    else 
            //    {
            //       $begin = ($pagee * $products_per_page) - $products_per_page;
            //    }
            //  // Modify the SQL query to include pagination
            //    $sql_tk .= " LIMIT $begin, $products_per_page";
            //     $sql_search = mysqli_query($conn, $sql_tk);
            ?>

            <div class="table">
               <table width="100%">
                  <thead>
                     <tr>
                        <td>Number</td>
                        <td>Name</td>
                        <td>Contact</td>
                        <td>Join Date</td>
                        <td>Function</td>
                        <td></td>
                     </tr>
                  </thead>
                  <tbody id="show-user">
                     <?php
                     
                     if(mysqli_num_rows($select_products)>0)
                     {
                        while ($fetch_users = mysqli_fetch_assoc($select_products)) 
                        {
                        if ($fetch_users['user_type'] === "user") 
                        {

                        ?>
                           <tr>

                              <td><?php echo $stt ?></td>
                              <?php $stt++ ?>
                              <td><?php echo $fetch_users['name']; ?></td>
                              <td><?php echo $fetch_users['phone_number']; ?></td>
                              <td><?php echo $fetch_users['date_time']; ?></td>
                              <td>
                                 <form method="GET">
                                    <?php
                                    if ($fetch_users['status'] == 1) {
                                    ?>
                                       <a id="btn-add-user" class="btn-control-large" type="submit" name="delete" href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">Delete</a>
                                       <a id="btn-add-user" class="btn-control-large" type="submit" name="block" href="admin_users.php?block=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Block this user?');" class="delete-btn">Block</a>
                                       <a id="btn-edit-user"class="btn-control-large" type="submit" name="edit" href="edit_user.php?id= <?php echo $fetch_users['id']; ?>">Edit</a>

                                    <?php
                                    } else {
                                    ?>
                                       <a id="btn-add-user" class="btn-control-large" type="submit" name="delete" href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">Delete</a>
                                       <a id="btn-add-user" class="btn-control-large" type="submit" name="unblock" href="admin_users.php?unblock=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Unblock this user?');" class="delete-btn">Unblock</a>
                                       <a id="btn-edit-user"class="btn-control-large" type="submit" name="edit" href="edit_user.php?id= <?php echo $fetch_users['id']; ?>">Edit</a>

                                    <?php
                                    }
                                    ?>
                              </td>
                           </tr>
                        <?php
                        }
                        
                     }
                  }

                  else {
                     echo '<div class="no-result"><div class="no-result-i"><i class="fa fa-home"></i></div><div class="no-result-h">No user exists</div></div>';
                 }
                  
                     ?>
                  </tbody>
               </table>
            </div>
            <!-- </div> -->

            <div class="pagination">
               
               <ul class="list_page">
                  <?php
                                    
                  for ($page = 1; $page <= $total_pages; $page++) {
                     // Kiểm tra xem có từ khóa tìm kiếm hay không
                     if (!empty($search_keyword)) {
                         echo '<li><a class="page-link" href="admin_users.php?page=' . $page . '&text_search=' . $search_keyword . '">' . $page . '</a></li>';
                     } else {
                         echo '<li><a class="page-link" href="admin_users.php?page=' . $page . '">' . $page . '</a></li>';
                     }
                 }
                  ?>
               </ul>
            </div>

            <style>
               .pagination {
                  text-align: center;
                  margin-top: 20px;
               }

               .pagination p {
                  margin: 0;
                  font-weight: bold;
                  text-align: center;
               }

               .list_page {
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  list-style-type: none;
                  padding: 0;
                  margin: 0;
               }

               .page-link {
                  display: inline-block;
                  padding: 8px 12px;
                  margin: 2px;
                  background-color: #f2f2f2;
                  color: #333;
                  text-decoration: none;
                  border-radius: 4px;
                  transition: background-color 0.3s ease;
               }

               .page-link:hover {
                  background-color: #ddd;
               }

               .page-link.active {
                  background-color: #007bff;
                  color: #fff;
               }
            </style>

      </main>
      <div id="toast"></div>
      <script src="js/admin.js"></script>
</body>

</html><script>
document.getElementById("btn-edit-user").addEventListener("click", function() {
    // Lấy ID của user từ thuộc tính 'data-id' của thẻ <a>
    var userId = this.getAttribute("data-id");
    // Kiểm tra xem userId có tồn tại không
    if (userId !== null) {
        // Nếu tồn tại, chuyển hướng người dùng đến trang edit_user.php với ID của user
        window.location.href = "edit_user.php?id=" + userId;
    } else {
        // Nếu không tồn tại, hiển thị thông báo hoặc xử lý phù hợp
        console.log("ID invalid.");
    }
});
</script>
</div>
</main>
<div id="toast"></div>
<script src="js/admin.js"></script>
</body>

</html>