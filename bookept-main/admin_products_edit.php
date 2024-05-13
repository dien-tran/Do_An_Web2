<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('Location:login_admin.php');
    exit();
}
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Lấy dữ liệu từ form
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $phone_number = $_POST['phone_number'];
//     $insert_query = "INSERT INTO users (name, email, password, user_type, phone_number) VALUES ('$name', '$email', '$password', '$user_type', '$phone_number')";
//     header('Location: admin_products.php');
//     exit();
// }
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
$update_id = $_GET['edit_product'];
if (isset($_POST['edit'])) {
    $update_name = $_POST['Name'];
    $update_price = $_POST['Price'];
    $update_old_image = $_FILES['Image']['name'];
    $update_image = $_FILES['Image']['name'];
    $update_author = $_POST['MainAuthor'];
    $update_publisher = $_POST['Publisher'];
    $update_pub_year = $_POST['PublicationYear'];
    $update_language = $_POST['Language'];
    $update_cover =  $_POST['CoverType'];
    $update_quantity = $_POST['Quantity'];
    $update_des = $_POST['Description'];
    $update_cate = $_POST['CategoryId'];

    mysqli_query($conn, "UPDATE products SET CategoryId = '$update_cate',Name = '$update_name', Price = '$update_price', MainAuthor = '$update_author',
    Publisher = '$update_publisher', PublicationYear = '$update_pub_year', Language = '$update_language', CoverType = '$update_cover', Quantity = '$update_quantity',
    Description = '$update_des' WHERE Id = '$update_id'");

    if (!empty($update_image)) {
        mysqli_query($conn, "UPDATE products SET Image = '$update_image' WHERE id = '$update_id'") or die('query failed');
        move_uploaded_file($_FILES["Image"]["tmp_name"], "image/" . $_FILES["Image"]["name"]);
        unlink('image/' . $update_old_image);
    }
    header('location:admin_products.php');
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
                            <div class="hidden-sidebar">Over view </div>
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
                        <a href="#" class="sidebar-link" >
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
            <div class="section product-all active">
                <div class="admin-control">
                    <div class="admin-control-center">
                        <form method="get" class="form-search">
                            <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            <span class="search-btn"><i class="fa fa-search"></i></span>
                            <input id="form-search-product" type="text" name="search" class="form-search-input" placeholder="Search book name...">
                            <button type="submit" name="submit_search" class="btn-control-large ">Search</button>
                        </form>
                    </div>
                    <div class="admin-control-right">
                        <button class="btn-control-large" id="btn-add-product"><i class="fa fa-plus"></i> Add new product</button>
                    </div>
                </div>
                <div id="show-product">
                    <?php
                    $products_per_page = 8;

                    // Tính số trang dựa trên tổng số sản phẩm và số sản phẩm mỗi trang
                    $total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `products`"));
                    $total_pages = ceil($total_products / $products_per_page);

                    // Lấy trang hiện tại từ tham số truyền vào hoặc mặc định là trang 1
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                    // Tính offset (bắt đầu lấy từ vị trí nào trong cơ sở dữ liệu)
                    $offset = ($current_page - 1) * $products_per_page;
                    $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT $offset, $products_per_page") or die('query failed');


                    if (mysqli_num_rows($select_products) > 0) {
                        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    ?>
                            <div class="list">
                                <div class="list-left">
                                    <img src="./image/<?php echo $fetch_products['Image'] ?>" alt="">
                                    <div class="list-info">
                                        <h4><?php echo $fetch_products['Name'] ?></h4>
                                        <p class="list-note"><?php echo $fetch_products['Description'] ?></p>
                                        <span class="list-category">
                                            <?php $category = mysqli_query($conn, "SELECT * FROM products p INNER JOIN category c ON p.CategoryId = c.CateId");
                                            if (mysqli_num_rows($category) > 0) {
                                                while ($fetch = mysqli_fetch_assoc($category)) {
                                                    if ($fetch['CateId'] == $fetch_products['CategoryId']) {
                                                        echo $fetch['CateName'];
                                                    }
                                                }
                                            }
                                            ?></span>
                                    </div>
                                </div>
                                <div class="list-right">
                                    <div class="list-price">
                                        <span class="list-current-price"><?php echo $fetch_products['Price'] ?>$</span>
                                    </div>
                                    <div class="list-control">
                                    <div class="list-tool">
                                            <a href="admin_products_edit.php?edit_product=<?php echo $fetch_products['Id']; ?>" style="color:black;"><button id="edit-product" name="edit" class="btn-edit"><i class="fa fa-pencil"></i></button></a>
                                            <?php
                                            if ($fetch_products['Status'] == 0) {
                                            ?>

                                                <a style="color:black" href="admin_products.php?display=<?php echo $fetch_products['Id'] ?>"><button name="display" class="btn-edit" onclick="return confirm('Do you want to continue selling this item?')"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                                <?php } elseif ($fetch_products['Status'] == 1) {
                                                ?>
                                                    <a href="admin_products.php?delete=<?php echo $fetch_products['Id']; ?>"><button class="btn-delete" name="delete" onclick="return confirm('Delete this product?')"><i class="fa fa-trash"></i></button> </a>
                                                <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="no-result"><div class="no-result-i"><i class="fa fa-home"></i></div><div class="no-result-h">Không có sản phẩm để hiển thị</div></div>';
                    }
                    ?>
                    <div class="page-nav">
                        <ul class="page-nav-list">
                            <?php
                            // Hiển thị các nút phân trang
                            for ($page = 1; $page <= $total_pages; $page++) {
                                echo '<li class="page-nav-item"><a href="admin_products.php?page=' . $page . '">' . $page . '</li></a>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
        </main>
        <input type="hidden" id="edit-product-id" name="edit_product_id">
        <div class="modal edit-product open">
            <div class="modal-container">
                <h3 class="modal-container-title edit-product-e">EDIT PRODUCT</h3>
                <a href="admin_products.php"><button class="modal-close product-form"><i class="fa fa-times"></i></button></a>
                <div class="modal-content">
                    <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
                        <div class="modal-content-left">
                            <?php
                            $product_id = $_GET['edit_product'];
                            $sql_product = mysqli_query($conn, "SELECT * FROM products WHERE Id = '$product_id'");

                            if (mysqli_num_rows($sql_product) > 0) {
                                while ($fetch_products_edit = mysqli_fetch_assoc($sql_product)) {
                            ?>
                                    <img id="imagePreview" src="./image/<?php echo $fetch_products_edit['Image'] ?>" alt="" class="upload-image-preview">
                                    <div class="form-group file">
                                        <label for="up-hinh-anh" class="form-label-file"><i class="fa fa-plus"></i>Choose image</label>
                                        <input accept="image/jpeg, image/png, image/jpg" id="up-hinh-anh" name="Image" type="file" class="form-control" onchange="previewImage(event)">
                                    </div>
                        </div>
                        <div class="modal-content-right">
                            <div class="form-group">
                                <label for="ten-mon" class="form-label">Book name</label>
                                <input id="ten-mon" name="Name" type="text" placeholder="Nhập tên sách" value="<?php echo $fetch_products_edit['Name'] ?>" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="category" class="form-label">Choose category</label>
                                <select name="CategoryId" id="chon-mon">
                                    <?php
                                    $a = $fetch_products_edit['CategoryId'];
                                    $sql_cate = "SELECT * FROM category";
                                    $result = mysqli_query($conn, $sql_cate);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($a == $row['CateId']) {
                                                echo '<option selected value="' . $row['CateId'] . '">' . $row['CateName'] . '</option>';
                                            } else {
                                                echo '<option value="' . $row['CateId'] . '">' . $row['CateName'] . '</option>';
                                            }
                                        }
                                        echo '</select>';
                                    }
                                    ?>
                                    <span class="form-message"></span>
                            </div>
                            <!-- Price -->
                            <div class="form-group">
                                <label for="gia-moi" class="form-label">Price</label>
                                <input id="gia-moi" name="Price" type="text" placeholder="Nhập giá bán" value="<?php echo $fetch_products_edit['Price'] ?>" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <!-- Author -->
                            <div class="form-group">
                                <label for="author" class="form-label">Author</label>
                                <input id="author" name="MainAuthor" type="text" value="<?php echo $fetch_products_edit['MainAuthor'] ?>" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="publisher" class="form-label">Publisher</label>
                                <input id="publisher" name="Publisher" value="<?php echo $fetch_products_edit['Publisher'] ?>" type="text" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="pub-year" class="form-label">PublicationYear</label>
                                <input id="pub-year" name="PublicationYear" value="<?php echo $fetch_products_edit['PublicationYear'] ?>" type="number" min="0" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="language" class="form-label">Language</label>
                                <input id="language" name="Language" value="<?php echo $fetch_products_edit['Language'] ?>" type="text" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="cover" class="form-label">Cover</label>
                                <input id="cover" name="CoverType" value="<?php echo $fetch_products_edit['CoverType'] ?>" type="text" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="quanitiy" class="form-label">Quantity</label>
                                <input id="quanitiy" name="Quantity" value="<?php echo $fetch_products_edit['Quantity'] ?>" type="number" min="0" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="mo-ta" class="form-label">Description</label>
                                <textarea class="product-desc" id="mo-ta" name="Description" placeholder="Enter description..."><?php echo $fetch_products_edit['Description'] ?></textarea>
                                <span class="form-message"></span>
                            </div>
                            <button name="edit" class="form-submit btn-update-product-form edit-product-e" id="update-product-button">
                                <i class="fa fa-floppy-o"></i>
                                <span>SAVE CHANGES</span>
                            </button>
                    <?php
                                }
                            }
                    ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="js/admin.js">
        </script>
        <script>
            let links = document.querySelectorAll('.page-nav-item');
            let bodyId = parseInt(document.body.id) - 1;
            console.log(links + "as" + bodyId);
            links[bodyId].classList.add('active');
        </script>

</body>

</html>