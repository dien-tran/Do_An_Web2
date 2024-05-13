<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_cart_numbers) > 0) {
      $message[] = 'already added to cart!';
   } else {
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }    
}

$products_per_page = 8;

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
    <title>Bookept | Shop</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="public/favicon.ico">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main.css">

    <link rel="stylesheet" href="styles/customers/service.css">

    <style>
    .action
   {
      display: flex;
      justify-content: center; /* Canh giữa theo chiều ngang */
      align-items: center; /* Canh giữa theo chiều dọc */
   }

    .action button 
    {
        margin: 0 auto; /* Đảm bảo các nút button nằm chính giữa */
    }
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
        background-color: #ddd; /* Màu nền xám */
        padding: 15px 30px; /* Kích thước padding */
        border-radius: 10px;
    }

    .pagination-justify-content-center .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #ddd; /* Màu nền xám */
    }

    .pagination-justify-content-center .page-item.active .page-link {
        /* color: #613d8a; màu nút khi được bấm */
        color: red  ;
    }

    .pagination-justify-content-center .page-link {
        color: black; 
    }

    .pagination-justify-content-center .page-link:hover {
        color: purple; /* Màu chữ khi hover */
        text-decoration: none;

    }
</style>

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>our shop</h3>
        <p> <a href="home.php">home</a> / shop </p>
    </div>

    <section class="products">
        <h1 class="title">latest products</h1>
        <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT $products_per_page OFFSET $offset") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    if($fetch_products['Status'] == 1)
                    {
            ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['Price']; ?>" class="price">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['Image']; ?>">

                        <a href="products_details.php?product_id=<?php echo $fetch_products['Id']; ?>">
                            <div class="image">
                                <img src="image/<?php echo $fetch_products['Image']; ?>" alt="">
                            </div>
                        </a>
                        <div class="details">
                            <div class="name" style="font-size: 14px;">
                                <img src="./public/card/name.svg" alt="name_icon">
                                <?php echo $fetch_products['Name']; ?>
                            </div>
                            <input type="hidden" name="product_name" value="<?php echo $fetch_products['Name']; ?>">
                            <div class="qty-pri">
                                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                                <div class="price">
                                    <span style="font-size:0.7em">$</span><?php echo $fetch_products['Price']; ?>
                                </div>
                            </div>
                            <div class="action">
                                <button type="submit" name="add_to_cart"><img src="./public/card/cart.svg" alt="cart_icon">add to cart</button>
                                <!-- <img src="./public/card/heart.svg" alt="favourite_icon"> -->
                            </div>
                        </div>
                    </form>
            <?php
                }
            }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>

    </section>

   <!-- Pagination -->
<nav aria-label="Page navigation example">
    <ul class="pagination-justify-content-center">
    <li class="page-item <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $current_page == 1 ? '#' : '?page=' . 1; ?>"> First </a>
        </li>
        <li class="page-item <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?php echo $current_page == 1 ? '#' : '?page=' . ($current_page - 1); ?>" tabindex="-1"> < </a>
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

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>