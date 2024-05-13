<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
};

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
};
$search_keyword = isset($_GET['search']) ? $_GET['search'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bookept | Search</title>
   <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
   <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
   <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="styles/main.css">

   <style>
      select {
         padding: 8px;
         border: 1px solid black;
         border-radius: 5px;
      }
   </style>
   <style>
      .page-nav {
    text-align: center; /* Canh giữa nội dung */
    margin-top: 20px; /* Khoảng cách từ phần trên cùng */
}

.page-nav-list {
    list-style-type: none; /* Loại bỏ dấu chấm đầu dòng */
    padding: 0;
    margin: 0;
}

.page-nav-item {
    display: inline-block; /* Hiển thị các mục trên cùng một dòng */
    margin-right: 5px; /* Khoảng cách giữa các mục */
    font-size: 18px;
}

.page-nav-item a {
    text-decoration: none; /* Loại bỏ đường gạch chân */
    padding: 5px 10px; /* Kích thước phần padding cho mỗi mục */
    border: 1px solid #ccc; /* Viền xung quanh mỗi mục */
    border-radius: 5px; /* Bo tròn góc */
    background-color: #f0f0f0; /* Màu nền mặc định */
    color: #333; /* Màu chữ mặc định */
}

.page-nav-item a:hover,
.page-nav-item a:focus,
.page-nav-item a:active { /* Khi được chọn hoặc di chuột qua */
    background-color: #ff0000; /* Màu nền màu đỏ */
    color: #fff; /* Màu chữ màu trắng */
}


   </style>
</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>search page</h3>
      <p> <a href="home.php">home</a> / search </p>
   </div>

   <section class="search-form">
      <form action="" method="post">
         <?php

         // Thực hiện truy vấn SQL để lấy dữ liệu từ cột 'CateName'
         $sql_category = "SELECT CateName FROM category"; // Thay 'table_name' bằng tên bảng thực tế của bạn
         $result_category = mysqli_query($conn, $sql_category);

         // Kiểm tra xem có kết quả trả về không
         if (mysqli_num_rows($result_category) > 0) {
            // Bắt đầu select box
            echo "<select name='category_name' id='category_name'>";
            echo "<option value='' selected disabled >Type</option>"; // Option mặc định

            // Lặp qua kết quả và tạo các option
            while ($row = mysqli_fetch_assoc($result_category)) {
               echo "<option value='" . $row['CateName'] . "'>" . $row['CateName'] . "</option>";
            }

            // Kết thúc select box
            echo "</select>";
         } else {
            echo "Không có dữ liệu";
         }

         $sql_product = "SELECT MainAuthor FROM products"; // Thay 'table_name' bằng tên bảng thực tế của bạn
         $result_product = mysqli_query($conn, $sql_product);

         // Kiểm tra xem có kết quả trả về không
         if (mysqli_num_rows($result_product) > 0) {
            // Bắt đầu select box
            echo "<select name='author' id='author' style='width:75%;'>";
            echo "<option value='' selected disabled >Author</option>"; // Option mặc định

            // Lặp qua kết quả và tạo các option
            while ($row = mysqli_fetch_assoc($result_product)) {
               echo "<option value='" . $row['MainAuthor'] . "'>" . $row['MainAuthor'] . "</option>";
            }
            echo "</select>";
            
            $sql_product = "SELECT PublicationYear FROM products ORDER BY PublicationYear ASC"; // Replace 'table_name' with the actual table name
            $result_product = mysqli_query($conn, $sql_product);
            echo "<select name='year' id='year'>";
            echo "<option value='' selected disabled>Publication Year</option>"; // Default option
            echo "<option value='1800-1900'>1800-1900</option>";
            echo "<option value='1900-2000'>1900-2000</option>";
            echo "<option value='Above_2000'>Above 2000</option>";
            echo "</select>";

            

            $sql_product = "SELECT Publisher FROM products"; // Thay 'table_name' bằng tên bảng thực tế của bạn
            $result_product = mysqli_query($conn, $sql_product);
            echo "<select name='publisher' id='publisher' style='width:75%;'>";
            echo "<option value='' selected disabled >Publisher</option>"; // Option mặc định

            // Lặp qua kết quả và tạo các option
            while ($row = mysqli_fetch_assoc($result_product)) {
               echo "<option value='" . $row['Publisher'] . "'>" . $row['Publisher'] . "</option>";
            }
            echo "</select>";


            $sql_product = "SELECT DISTINCT Language FROM products"; // Thay 'table_name' bằng tên bảng thực tế của bạn
            $result_product = mysqli_query($conn, $sql_product);
            echo "<select name='language' id='language-select'>";
            echo "<option value='' selected disabled >Language</option>"; // Option mặc định

            // Lặp qua kết quả và tạo các option
            while ($row = mysqli_fetch_assoc($result_product)) {
               echo "<option value='" . $row['Language'] . "'>" . $row['Language'] . "</option>";
            }
            // Kết thúc select box
            echo "</select>";

            $sql_product = "SELECT DISTINCT CoverType FROM products"; // Thay 'table_name' bằng tên bảng thực tế của bạn
            $result_product = mysqli_query($conn, $sql_product);
            echo "<select name='cover' id='cover'>";
            echo "<option value='' selected disabled >Cover Type</option>"; // Option mặc định

            // Lặp qua kết quả và tạo các option
            while ($row = mysqli_fetch_assoc($result_product)) {
               echo "<option value='" . $row['CoverType'] . "'>" . $row['CoverType'] . "</option>";
            }
            // Kết thúc select box
            echo "</select>";


            echo "<input type='text' name = 'min_price' placeholder='Min Price' style='width:58px;border: 1px solid black;border-radius: 5px;font-size: 12px;text-align: center;'>";
            echo "<input type='text' name = 'max_price' placeholder='Max Price'style='width:59px;border: 1px solid black;border-radius: 5px;font-size: 12px;text-align: center;'>";
         } else {
            echo "Không có dữ liệu";
         }
         ?>


         <input type="text" name="search" placeholder="search..." class="box">
         <input type="submit" name="submit" value="search" class="btn">
      </form>
   </section>

   <section class="products" style="padding-top: 0;">
      <div class="box-container">
         <?php
         $limit = 4;
         $getquery = "SELECT * FROM products";
         $result = mysqli_query($conn, $getquery);
         $total_rows = mysqli_num_rows($result);
         $total_pages = ceil($total_rows / $limit);
         if (!isset($_GET['page'])) {
            $page_number = 1;
         } else {
            $page_number = $_GET['page'];
         }
         $initial_page = ($page_number - 1) * $limit;
         if (!isset($_POST['submit'])) {

            $getquery = "SELECT * FROM products LIMIT $initial_page, $limit";
            $result = mysqli_query($conn, $getquery);
            if (mysqli_num_rows($result) > 0) {
               while ($fetch_product = mysqli_fetch_assoc($result)) {
         ?>
                  <form action="" method="post" class="box" style="padding-left: 20px;">
                     <a href="products_details.php?product_id=<?php echo $fetch_product['Id']; ?>">
                        <img src="image/<?php echo $fetch_product['Image']; ?>" alt="" class="image" style="align: center;">
                     </a>
                     <div class="name" style="font-size: 15px;"><?php echo $fetch_product['Name']; ?></div>
                     <div class="price" style="font-size: 15px;">$<?php echo $fetch_product['Price']; ?>/-</div>
                     <input type="number" class="qty" name="product_quantity" min="1" value="1">
                     <input type="hidden" name="product_name" value="<?php echo $fetch_product['Name']; ?>">
                     <input type="hidden" name="product_price" value="<?php echo $fetch_product['Price']; ?>">
                     <input type="hidden" name="product_image" value="<?php echo $fetch_product['Image']; ?>">
                     <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                  </form>
                  <?php
               }
               ?>
               </div>
               <div class="page-nav">
                     <ul class="page-nav-list">
               <?php
               for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
                  echo '<li class="page-nav-item"><a href="search_page.php?page=' . $page_number . '">' . $page_number . '</a></li>';
                     // Kiểm tra xem có từ khóa tìm kiếm hay không
               }
               echo '</ul> </div>';
            }
         } else {
            if (isset($_POST['submit'])) {
               $sql = "SELECT * FROM products where 1=1 ";

               if (!empty($_POST['category_name'])) {
                  $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

                  $sql_category_id = "SELECT CateId FROM category WHERE CateName = '$category_name'";
                  $result_category_id = mysqli_query($conn, $sql_category_id);

                  if (mysqli_num_rows($result_category_id) > 0) {
                     $row_category_id = mysqli_fetch_assoc($result_category_id);
                     $category_id = $row_category_id['CateId'];
                     $sql .= "AND CategoryId = '$category_id'";
                  }
               }
               if (!empty($_POST['author'])) {
                  $author = mysqli_real_escape_string($conn, $_POST['author']);
                  $sql .= " AND MainAuthor = '$author'";
               }
               if (!empty($_POST['publisher'])) {
                  $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);
                  $sql .= " AND Publisher = '$publisher'";
               }

               if (!empty($_POST['year'])) {
                  $year = mysqli_real_escape_string($conn, $_POST['year']);         

                  if ($year == '1800-1900') {
                      $sql .= "AND `PublicationYear` BETWEEN 1800 AND 1900";
                  } elseif ($year == '1900-2000') {
                      $sql .= "AND `PublicationYear` BETWEEN 1900 AND 2000";
                  } else {
                      $sql .= "AND `PublicationYear` > 2000";
                  }

               }
               if (!empty($_POST['language'])) {
                  $language = mysqli_real_escape_string($conn, $_POST['language']);
                  $sql .= " AND Language = '$language'";
               }
               if (!empty($_POST['cover'])) {
                  $cover = mysqli_real_escape_string($conn, $_POST['cover']);
                  $sql .= " AND CoverType = '$cover'";
               }
               // Kiểm tra xem giá trị đã nhập vào có hợp lệ không
               $min_price = $_POST['min_price'];
               $max_price = $_POST['max_price'];
               // Kiểm tra xem có giá trị hợp lệ không
               if (!empty($min_price) && !empty($max_price)) {
                  // Chuyển đổi giá trị thành số nguyên để tránh lỗ hổng bảo mật SQL Injection
                  $min_price = intval($min_price);
                  $max_price = intval($max_price);
                  // Tạo câu truy vấn SQL để lấy các sản phẩm trong khoảng giá trị min và max
                  $sql .= "AND Price > $min_price AND Price < $max_price";
               }
               if (!empty($_POST['search'])) {
                  $search_item = mysqli_real_escape_string($conn, $_POST['search']);
                  $sql .= "AND name LIKE '%$search_item%'";
               }
               if (!isset($_GET['page'])) {
                  $page_number = 1;
               } else {
                  $page_number = $_GET['page'];
               }
               $result = mysqli_query($conn, $sql) or die("query failed");
               if (mysqli_num_rows($result) > 0) {
                  while ($fetch_product = mysqli_fetch_assoc($result)) {
                  ?>
                     <form action="" method="post" class="box" style="padding-left: 20px;">
                        <a href="products_details.php?product_id=<?php echo $fetch_product['Id']; ?>">
                           <img src="image/<?php echo $fetch_product['Image']; ?>" alt="" class="image" style="align: center;">
                        </a>
                        <div class="name" style="font-size: 15px;"><?php echo $fetch_product['Name']; ?></div>
                        <div class="price" style="font-size: 15px;">$<?php echo $fetch_product['Price']; ?>/-</div>
                        <input type="number" class="qty" name="product_quantity" min="1" value="1">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['Name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['Price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['Image']; ?>">
                        <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                     </form>

         <?php
                  }
               }
            }
         }
         ?>


   </section>
   
   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>