<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login_customer.php');
  exit();
}

if (isset($_POST["bill"]))
{
  header("location:bill.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
   <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
   <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="edit_customer.css">
   <link rel="stylesheet" href="styles/main.css">

   <style>
    .box {
        width: 450px;
    }
    </style>
</head>
<body>

<?php include 'header.php'; ?>
<div class="heading">
   <h3>BILL Details</h3>
   <p> <a href="home.php">home</a></p>
</div>
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
<div class="from_container">
  <div class="container">
    <br>
    <form action="" method="POST" id="form">
      <?php
      $sql = mysqli_query($conn, "SELECT * FROM `users` WHERE id=$user_id");
      $check = mysqli_fetch_assoc($sql); // lấy từng cột giá trị trên bảng users
      $sql_bill = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id=$user_id ORDER BY id DESC LIMIT 1");
      $order_info = mysqli_fetch_assoc($sql_bill);
        
      $sql_detailsbill = mysqli_query($conn, "SELECT * FROM `bill`  WHERE IdUser =$user_id ORDER BY IdBill DESC LIMIT 1 ");
      $bill_info = mysqli_fetch_assoc($sql_detailsbill);
      ?>
      <table>
    <?php
    $total_products = $order_info['total_products']; // Lấy giá trị từ cột total_products
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

        // Truy vấn cơ sở dữ liệu để lấy thông tin về sản phẩm
        $sql_product = mysqli_query($conn, "SELECT * FROM products WHERE name='$product_name'");
        $product_detail = mysqli_fetch_assoc($sql_product);

        // Tính toán tổng tiền cho sản phẩm
        $product_price = $product_detail['Price']; // Giá của sản phẩm
        $total_price = $product_price * $product_quantity; // Tổng tiền cho sản phẩm

        // Hiển thị thông tin sản phẩm và tổng tiền
        echo "<tr>";
        echo "<td><label for='product_info'>Product ($product_number):</label></td>"; 
        echo "<td><input type='text' value='$product_name (Amount: $product_quantity) - Total: $$total_price' class='box' readonly></td>";
        echo "</tr>";

        $product_id_info[] = $product_detail['Id'];
        $product_names_info[] = $product_name;
        $product_quantities_info[] =  $product_quantity;
        $product_prices_info[] = $total_price;

        $product_number++;
    }
    
    $product_id_str = implode(', ', $product_id_info);
    $product_names_str = implode(', ', $product_names_info);
    $product_quantities_str = implode(', ', $product_quantities_info);
    $product_prices_str = implode(', ', $product_prices_info);

    // Chèn dữ liệu vào bảng detailsbill
    $sql_check_detailsbill = "SELECT * FROM detailsbill 
    WHERE IdBill = '{$bill_info['IdBill']}'";

    $result_check_detailsbill = mysqli_query($conn, $sql_check_detailsbill);

    if (mysqli_num_rows($result_check_detailsbill) == 0) {
        $sql_insert_details = "INSERT  INTO detailsbill (IdBill, IdProduct, ProductName, ProductAmount, TotalMoneyEachProduct) 
                    VALUES ('{$bill_info['IdBill']}', '$product_id_str', '$product_names_str', '$product_quantities_str', '$product_prices_str')";

        if (mysqli_query($conn, $sql_insert_details)) {
            echo '<span style="color: white;">Details inserted successfully.</span>';
        } else {
            echo "Error inserting details: " . mysqli_error($conn);
        }
    } else {
        echo '<span style="color: white;">Details already existed.</span>';
    }

    echo "<tr>";
    echo "<td><label>Total Price:</label></td>";
    echo "<td><input type='text' value='$" . $order_info['total_price'] . "' class='box' readonly></td>";
    echo "</tr>";

    ?>
</table>

      <div class="button_form">
        <input type="button" onclick="window.location.href = 'home.php';" value="Return">
        <input type="submit" name="bill" onclick="window.location.href = 'bill.php';" value="View Bill">
      </div>
    </form>
  </div>
</div>
</body>
