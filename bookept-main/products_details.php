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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookept | Product Details</title>
    <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
    <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
    <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/customers/about.css">
    <link rel="stylesheet" href="styles/customers/service.css">
    <style>
        .action {
            display: ruby;
            
        }

        .action button {
            margin: 0 auto;
            /* Đảm bảo các nút button nằm chính giữa */
        }

        #product_img {
            float: left;
            width: 50%;
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Our Product</h3>
        <p> <a href="home.php">home</a> / <a href="shop.php">shop</a></p>
    </div>

    <section class="about">
        <div class="flex">
            <?php
            if (isset($_GET['product_id'])) {
                // Lấy ID sản phẩm từ URL
                $product_id = $_GET['product_id'];

                // Truy vấn CSDL để lấy thông tin chi tiết của sản phẩm dựa trên ID
                $sql = "SELECT * FROM products WHERE Id = $product_id";
                $result = mysqli_query($conn, $sql);

                // Kiểm tra xem có sản phẩm nào tương ứng không
                if (mysqli_num_rows($result) > 0) {
                    // Lấy thông tin sản phẩm
                    $product = mysqli_fetch_assoc($result);
            ?>
                    <div class="image">
                        <img id="product_img" src="image/<?php echo $product['Image']; ?>" alt="">
                    </div>

                    <div class="content">
                        <div class="details">
                            <div class="name" style="font-size:30px; color: purple;">
                                <img src="./public/card/name.svg" alt="name_icon">
                                <?php echo $product['Name']; ?>
                            </div>
                            <?php echo "<br>"; ?>
                            <div class="info">
                                <div class="label">
                                    <p style="font-size: 15px; color:black"> Publisher: <b><?php echo $product['Publisher']; ?></b> </p>
                                    <div class="label">
                                        <p style="font-size: 15px; color:black">Author: <b><?php echo $product['MainAuthor']; ?> </b></p>
                                    </div>
                                </div>

                                <div class="info">
                                    <div class="label">
                                        <p style="font-size: 15px; color:black">Languge:<b> <?php echo $product['Language']; ?></b> </p>
                                    </div>
                                    <div class="label">
                                        <p style="font-size: 15px; color:black">Cover Type:<b> <?php echo $product['CoverType']; ?></b> </p>
                                    </div>
                                </div>

                                <div class="qty-pri" style="width: 100px">
                                    <div class="price" style="font-size: 15px">
                                        <div class="label">
                                            <p style="font-size: 15px; color:black">Price: <b> $<?php echo $product['Price']; ?></b> </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="info">
                                    <div class="label">
                                        <p style="font-size: 15px; color: black;"><b>Description: </b></p>
                                        <p style="font-size: 15px; color: black; white-space: pre-line; text-align: justify;"><?php echo $product['Description']; ?></p>
                                    </div>
                                </div>
                                <div class="box-container">
                                <?php
                                $id = $_GET['product_id'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE Id = '$id' ") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    if($fetch_products['Status'] == 1)
                    {
            ?>
                                    <form class="box" method="post">
                                        <div class="action">
                                            <button type="submit" name="add_to_cart"><img src="./public/card/cart.svg" alt="cart_icon">add to cart</button>
                                        </div>
                                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['Image']; ?>">
                                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['Name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['Price']; ?>">
                                        <div class="qty-pri">
                                            <input type="number" min="1" name="product_quantity" value="1" class="qty">

                                        </div>
                                    </form>
                                    <?php 
                    }
                }
            }
                                    ?>
                                </div>
                            </div>
                        </div>
                <?php
                } else {
                    echo 'Không tìm thấy sản phẩm!';
                }
            } else {
                echo 'Không có ID sản phẩm được chỉ định!';
            }
                ?>
                    </div>
    </section>



    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>