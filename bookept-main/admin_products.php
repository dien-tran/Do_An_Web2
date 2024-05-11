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

if (isset($_POST['add_product'])) {
    $name = $_POST['Name'];
    $price = $_POST['Price'];
    $image = $_FILES['Image']['name'];
    $image_tmp_name = $_FILES['Image']['tmp_name'];
    $author = $_POST['MainAuthor'];
    $publisher = $_POST['Publisher'];
    $pub_year = $_POST['PublicationYear'];
    $language = $_POST['Language'];
    $cover =  $_POST['CoverType'];
    $quantity = $_POST['Quantity'];
    $des = $_POST['Description'];
    $cate = $_POST['CategoryId'];
    $select_product_name = mysqli_query($conn, "SELECT Name FROM products WHERE Name = '$name'") or die('query failed');
        $add_product_query = mysqli_query($conn, "INSERT INTO products(CategoryId, Name, Price, Image, MainAuthor, Publisher, PublicationYear, Language, CoverType, Quantity, Description)
         VALUES('$cate','$name', '$price', '$image', '$author', '$publisher', '$pub_year', '$language', '$cover', '$quantity', '$des')") or die('query failed');

        if ($add_product_query) {
            move_uploaded_file($_FILES["Image"]["tmp_name"], "image/" . $_FILES["Image"]["name"]);
            $message[] = $cate;
        } else {
            $message[] = 'product could not be added!';
    }
}
if (isset($_GET['delete'])) // kiểm tra xem có tồn tại tham số 'delete' trong mảng $_GET hay không nếu có gì có id
{
    $delete_id = $_GET['delete']; // nếu có thì lấy id 
    mysqli_query($conn, "DELETE FROM products WHERE id = '$delete_id'") or die('query failed');
}
if (isset($_GET['block'])) {
    $block_id = $_GET['block'];
    $sql_block = mysqli_query($conn, "SELECT * FROM  users WHERE id=$block_id");
    if (mysqli_num_rows($sql_block) > 0) {
        $query = "UPDATE users SET status = 0 WHERE id = $block_id";
    }
}
if (isset($_GET['edit'])) {
}

$products_per_page = 2;

// Tính số trang dựa trên tổng số sản phẩm và số sản phẩm mỗi trang
$total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `products`"));
$total_pages = ceil($total_products / $products_per_page);

// Lấy trang hiện tại từ tham số truyền vào hoặc mặc định là trang 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính offset (bắt đầu lấy từ vị trí nào trong cơ sở dữ liệu)
$offset = ($current_page - 1) * $products_per_page;
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
    <style>
        .pagination-justify-content-center {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .pagination-justify-content-center .page-item {
            display: inline-block;
            margin-right: 5px;
            background-color: #ddd;
            /* Màu nền xám */
            padding: 15px 30px;
            /* Kích thước padding */
            border-radius: 10px;
        }

        .pagination-justify-content-center .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #ddd;
            /* Màu nền xám */
        }

        .pagination-justify-content-center .page-item.active .page-link {
            /* color: #613d8a; màu nút khi được bấm */
            color: red;
        }

        .pagination-justify-content-center .page-link {
            color: black;
        }

        .pagination-justify-content-center .page-link:hover {
            color: purple;
            /* Màu chữ khi hover */
            text-decoration: none;

        }
    </style>
</head>

<body>
<?php
if(isset($message) && is_array($message)) // Kiểm tra nếu $message là một mảng
{
    foreach($message as $msg)
    {
        echo '
        <div class="message">
        <span>' . $msg . '</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>'; // Thêm </div> ở cuối để đóng div.message
    }
}
?>
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
                    <li id="main" class="sidebar-list-item tab-content">
                        <a href="admin_main.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-home"></i></div>
                            <div class="hidden-sidebar">Trang tổng quan</div>
                        </a>
                    </li>
                    <li class="sidebar-list-item tab-content active">
                        <a href="admin_products.php" class="sidebar-link">
                            <div class="sidebar-icon"><i class="fa fa-book"></i></div>
                            <div class="hidden-sidebar">Sản phẩm</div>
                        </a>
                    </li>
                    <li id="customers" class="sidebar-list-item tab-content">
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
                        <a href="#" class="sidebar-link" id="logout-acc">
                            <div class="sidebar-icon"><i class="fa fa-arrow-right"></i></div>
                            <div class="hidden-sidebar">Đăng xuất</div>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="content">
            <div class="section product-all active">
                <div class="admin-control">
                    <div class="admin-control-left">
                    <select name="CategoryId">
                        <?php
                        $sql_cate = "SELECT * FROM category";
                        $result = mysqli_query($conn, $sql_cate);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['CateId'] . '">' . $row['CateName'] . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
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
                                    <img src="./image/<?php echo $fetch_products['Image'] ?>" alt="">
                                    <div class="list-info">
                                        <h4><?php echo $fetch_products['Name'] ?></h4>
                                        <p class="list-note"><?php echo $fetch_products['Description'] ?></p>
                                        <span class="list-category"><?php $category = mysqli_query($conn, "SELECT * FROM products p INNER JOIN category c ON p.CategoryId = c.CateId");
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
                                        <span class="list-current-price"><?php echo $fetch_products['Price'] ?></span>
                                    </div>
                                    <div class="list-control">
                                        <div class="list-tool">
                                            <button onclick="openEditPopup(<?php echo $fetch_products['Id']; ?>)" id="edit-product" name="edit" class="btn-edit"><i class="fa fa-pencil"></i></button>
                                            <a href="admin_products.php?delete=<?php echo $fetch_products['Id']; ?>"><button class="btn-delete" name="delete" onclick="return confirm('Delete this product?')"><i class="fa fa-trash"></i></button> </a>
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
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination-justify-content-center">
                        <li class="page-item <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo $current_page == 1 ? '#' : '?page=' . 1; ?>"> First </a>
                        </li>
                        <li class="page-item <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo $current_page == 1 ? '#' : '?page=' . ($current_page - 1); ?>" tabindex="-1">
                                < </a>
                        </li>
                        <?php
                        // Hiển thị các trang
                        for ($i = 1; $i <= $total_pages; $i++) {
                        ?>
                            <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="page-item <?php echo $current_page == $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo $current_page == $total_pages ? '#' : '?page=' . ($current_page + 1); ?>"> > </a>
                        </li>
                        <li class="page-item <?php echo $current_page == $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo $current_page == $total_pages ? '#' : '?page=' . ($total_pages); ?>"> Last </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </main>
        <div class="modal add-product">
            <div class="modal-container">
                <h3 class="modal-container-title add-product-e">THÊM MỚI SẢN PHẨM</h3>
                <button class="modal-close product-form"><i class="fa fa-times"></i></button>
                <div class="modal-content">
                    <form action="" method="POST" class="add-product-form" enctype="multipart/form-data">
                        <div class="modal-content-left">
                            <img id="imagePreview" src="./image/" alt="" class="upload-image-preview">
                            <div class="form-group file">
                                <label for="up-hinh-anh" class="form-label-file"><i class="fa fa-plus"></i>Chọn hình ảnh</label>
                                <input accept="image/jpeg, image/png, image/jpg" id="up-hinh-anh" name="Image" type="file" class="form-control" onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="modal-content-right">
                            <div class="form-group">
                                <label for="ten-mon" class="form-label">Tên sách</label>
                                <input id="ten-mon" name="Name" type="text" placeholder="Nhập tên sách" value="" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="category" class="form-label">Chọn thể loại</label>
                                <select name="CategoryId" id="chon-mon">
                                <?php
                                $sql_cate = "SELECT * FROM category";
                                $result = mysqli_query($conn, $sql_cate);
                                if (mysqli_num_rows($result) > 0) {
                                    // echo '<select name="CategoryId" id="chon-mon">';
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['CateId'] . '">' . $row['CateName'] . '</option>';
                                    }
                                    echo '</select>';
                                }
                                ?>
                                <span class="form-message"></span>
                            </div>
                            <!-- Price -->
                            <div class="form-group">
                                <label for="gia-moi" class="form-label">Price</label>
                                <input id="gia-moi" name="Price" type="text" placeholder="Nhập giá bán" value="" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <!-- Author -->
                            <div class="form-group">
                                <label for="author" class="form-label">Author</label>
                                <input id="author" name="MainAuthor" type="text" value="" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="publisher" class="form-label">Publisher</label>
                                <input id="publisher" name="Publisher" value="" type="text" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="pub-year" class="form-label">PublicationYear</label>
                                <input id="pub-year" name="PublicationYear" value="" type="number" min="0" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="language" class="form-label">Language</label>
                                <input id="language" name="Language" value="" type="text" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="cover" class="form-label">Cover</label>
                                <input id="cover" name="CoverType" value="" type="text" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="quanitiy" class="form-label">Quantity</label>
                                <input id="quanitiy" name="Quantity" value="" type="number" min="0" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="mo-ta" class="form-label">Mô tả</label>
                                <textarea class="product-desc" id="mo-ta" value="" name="Description" placeholder="Nhập mô tả sách..."></textarea>
                                <span class="form-message"></span>
                            </div>
                            <form method="post" enctype="multipart/form-data">
                            <button type="submit" class="form-submit btn-add-product-form add-product-e" id="add-product-button" name="add_product">
                                <i class="fa fa-plus"></i>
                                <span>THÊM SÁCH</span>
                            
                            </button>
                            </form>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <input type="hidden" id="edit-product-id" name="edit_product_id">
        <!-- <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $editProductId = $_POST['edit_product_id'];
            $sql_edit = mysqli_query($conn, "SELECT * FROM products WHERE Id = '$editProductId'");
            $fetch_products_edit = mysqli_fetch_assoc($sql_edit);
            echo '<script>alert("a");';
        }
        ?> -->
        <div class="modal edit-product">
            <div class="modal-container">
                <h3 class="modal-container-title edit-product-e">CHỈNH SỬA SẢN PHẨM</h3>
                <button class="modal-close product-form"><i class="fa fa-times"></i></button>
                <div class="modal-content">
                    <form action="" method="POST" class="add-product-form" enctype="multipart/form-data">
                        <div class="modal-content-left">
                            <img id="imagePreview" src="./image/ <?php echo $fetch_products_edit['Image']['name'] ?>" alt="" class="upload-image-preview">
                            <div class="form-group file">
                                <label for="up-hinh-anh" class="form-label-file"><i class="fa fa-plus"></i>Chọn hình ảnh</label>
                                <input accept="image/jpeg, image/png, image/jpg" id="up-hinh-anh" name="Image" type="file" class="form-control" onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="modal-content-right">
                            <div class="form-group">
                                <label for="ten-mon" class="form-label">Tên sách</label>
                                <input id="ten-mon" name="Name" type="text" placeholder="Nhập tên sách" value="<?php echo $fetch_products_edit['Name'] ?>" class="form-control">
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
                            <!-- Price -->
                            <div class="form-group">
                                <label for="gia-moi" class="form-label">Price</label>
                                <input id="gia-moi" name="Price" type="text" placeholder="Nhập giá bán" value="<?php echo $fetch_products_edit['Price'] ?>" class="form-control">
                                <span class="form-message"></span>
                            </div>
                            <!-- Author -->
                            <div class="form-group">
                                <label for="author" class="form-label">Author</label>
                                <input id="author" name="Author" type="text" value="<?php echo $fetch_products_edit['MainAuthor'] ?>" class="form-control">
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
                                <label for="mo-ta" class="form-label">Mô tả</label>
                                <textarea class="product-desc" id="mo-ta" value="<?php echo $fetch_products_edit['Description'] ?>" name="Description" placeholder="Nhập mô tả sách..."></textarea>
                                <span class="form-message"></span>
                            </div>
                            <button type="submit" class="form-submit btn-add-product-form add-product-e" id="add-product-button" name="add_product">
                                <i class="fa fa-plus"></i>
                                <span>THÊM SÁCH</span>
                            </button>
                            <a href="admin.php?update=<?php echo $fetch_products['Id']; ?>">
                                <button class="form-submit btn-update-product-form edit-product-e" id="update-product-button">
                                    <i class="fa fa-floppy-o"></i>
                                    <span>LƯU THAY ĐỔI</span>
                                </button>

                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="js/admin.js"></script>
</body>

</html>