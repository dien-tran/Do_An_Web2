<?php
include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
  echo  '<script>alert("User ID not set in session. Redirecting to login page...");</script>';
  header('refresh:0;url=login_customer.php');
  exit();
}
$user_id = $_SESSION['user_id'];
if ($user_id === null) {
  header('location:login_customer.php');
  exit();
}
$sql_check_order = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = $user_id");

if (mysqli_num_rows($sql_check_order) == 0) {
  echo  '<script>alert("User has no order. Redirecting to shop page...");</script>';
  header('refresh:0;url=shop.php');
  exit();
}
if (isset($_POST["bill_details"])) {
  header("location:bill_details.php");
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
      width: 500px;
    }
  </style>
</head>

<body>

  <?php include 'header.php'; ?>
  <div class="heading">
    <h3>BILL INFORMATION</h3>
    <p> <a href="home.php">home</a></p>
  </div>
  <?php
  if (isset($message) && is_array($message)) // Kiểm tra nếu $message là một mảng
  {
    foreach ($message as $msg) {
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
        $user_id = $_SESSION['user_id'];
        $sql = mysqli_query($conn, "SELECT * FROM `users` WHERE id=$user_id");
        $check = mysqli_fetch_assoc($sql); // lấy từng cột giá trị trên bảng users
        $sql_bill = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = $user_id ORDER BY id DESC LIMIT 1");
        $order_info = mysqli_fetch_assoc($sql_bill);
        $delivery_date = date('Y-m-d', strtotime($order_info['placed_on'] . ' +3 days'));
        ?>
        <table>

          <tr>
            <td><label for="name">Name:</label></td>
            <td><input type="text" id="name" name="name_change" value="<?php echo $check['name']; ?>" class="box" readonly></td>
          </tr>
          <tr>
            <td><label for="email">Email:</label></td>
            <td><input type="email" id="email" name="email_change" value="<?php echo $check['email']; ?>" class="box" readonly></td>
          </tr>
          <tr>
            <td><label for="phone">Telephone Number:</label></td>
            <td><input type="tel" id="phone" name="phone_number" value="<?php echo $check['phone_number']; ?>" class="box" readonly></td>
          </tr>
          <tr>
            <td><label for="address">Address:</label></td>
            <td><input type="text" id="address" name="address" value="<?php echo $order_info['address']; ?>" class="box" readonly></td>
          </tr>
          <tr>
            <td><label>Total Products:</label></td>
            <td><input type="text" value="<?php echo $order_info['total_products']; ?>" class="box" readonly></td>
          </tr>
          <tr>
            <td><label>Method paying:</label></td>
            <td><input type="text" value="<?php echo $order_info['method']; ?>" class="box" readonly></td>
          </tr>
          <tr>
            <td><label>Total Price:</label></td>
            <td><input type="text" value="$<?php echo $order_info['total_price']; ?>" class="box" readonly></td>
          </tr>

          <tr>
            <td><label>Ship date:</label></td>
            <td><input type="text" value="<?php echo $delivery_date; ?>" class="box" readonly></td>
          </tr>

          <tr>
            <td><label>Status:</label></td>
            <td><input type="text" value="<?php echo $order_info['payment_status']; ?>" class="box" readonly></td>
          </tr>
        </table>
        <?php
        // Kiểm tra xem có bản ghi nào trong bảng bill có các giá trị tương tự hay không
        $sql_check_bill = "SELECT * FROM bill 
                   WHERE IdUser = '$user_id' 
                   AND NameUser = '{$check['name']}' 
                   AND ShipDate = '$delivery_date' 
                   AND TotalPay = {$order_info['total_price']} 
                   AND MethodPayment = '{$order_info['method']}'
                   AND BillStatus = '{$order_info['payment_status']}'";
                   


        $result_check_bill = mysqli_query($conn, $sql_check_bill);

        // Nếu không có bản ghi nào có các giá trị tương tự, thêm bản ghi mới vào bảng bill
        if (mysqli_num_rows($result_check_bill) == 0) {
          $sql_insert_bill = "INSERT INTO bill (IdUser, NameUser, ShipDate, TotalPay, MethodPayment, BillStatus) 
                    VALUES ('$user_id', '{$check['name']}', '$delivery_date', {$order_info['total_price']}, '{$order_info['method']}', '{$order_info['payment_status']}')";


          if (mysqli_query($conn, $sql_insert_bill)) {
            echo '<span style="color: white;">Bill inserted successfully.</span>';
          } else {
            echo "Error inserting bill: " . mysqli_error($conn);
          }
        } else {
          echo '<span style="color: white;">Bill already existed.</span>';
        }
        ?>
        <div class="button_form">
          <input type="button" onclick="window.location.href = 'home.php';" value="Return">
          <input type="submit" name="bill_details" onclick="window.location.href = 'bill_details.php';" value="View Bill Details">
        </div>
      </form>
    </div>
  </div>
  <script src="js/script.js"></script>

</body>

</html>