<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login_customer.php');
  exit();
}

if (isset($_POST['submit'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name_change']);
  $email = mysqli_real_escape_string($conn, $_POST['email_change']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone_number']);
  $city = mysqli_real_escape_string($conn, $_POST['provinces']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $ward = mysqli_real_escape_string($conn, $_POST['ward']);
  $road = mysqli_real_escape_string($conn, $_POST['road']);
  $district=mysqli_real_escape_string($conn,$_POST['district']);
  // ban đầu. không có mảng arry thì session là:joppy đổi thành xucana thành công. nhưng sao đó đổi thành modmod  và bấm nút "Submit", thì lại không thành công . 
  // nguyên nhân:thay đổi thông tin từ "xucana" thành "modmod", điều kiện "xucana" sẽ được kiểm tra ở phía trên và một truy vấn cập nhật tên mới sẽ được tạo ra và thực thi. Sau đó, khi đến điều kiện "modmod", nếu không thay đổi bất kỳ trường thông tin nào khác, không có truy vấn SQL mới nào được tạo ra, vì vậy tên "modmod" không được cập nhật vào cơ sở dữ liệu.
  // dùng mảng arry () : sẽ được cập nhật bằng cách thêm giá trị mới vào mảng cho mỗi trường có dữ liệu mới được nhập vào form
  // giả sử đổi thành xucana thì arry sẽ thêm 1 trường đổi tên thành xucana sau đó foreach nó sẽ duyệt qua mảng và đổi tên. khi đổi thành modmod tiếp và submit. thì thêm trường đổi tên vào arry và tiếp tục foreach. việc này sẽ giúp không ghi đè dữ liệu
  $query=array();
  if ($name != $_SESSION['name']) {
    $query[] = "UPDATE `users` SET `name` = '$name' WHERE id = $user_id";
    $_SESSION['name'] = $name;
  } 
  if ($email != $_SESSION['email']) {
    $query[] = "UPDATE `users` SET `email` = '$email' WHERE id = $user_id";
    $_SESSION['email'] = $email;
  }
  if ($phone != $_SESSION['phone_number']) {
    $query[] = "UPDATE `users` SET `phone_number` = '$phone' WHERE id = $user_id";
    $_SESSION['phone_number'] = $phone;
  } 
  if ($address != $_SESSION['house_number']) {
    $query[] = "UPDATE `users` SET `house_number` = '$address' WHERE id = $user_id";
    $_SESSION['house_number'] = $address;
  }
   if ($road != $_SESSION['road']) {
    $query[] = "UPDATE `users` SET `road` = '$road' WHERE id = $user_id";
    $_SESSION['road'] = $road; 
  } 
  if ($ward != $_SESSION['ward']) {
    $query[] = "UPDATE `users` SET `ward` = '$ward' WHERE id = $user_id";
    $_SESSION['ward'] = $street;
  } 
  if ($city != $_SESSION['city']) {
    $query[] = "UPDATE `users` SET `city` = '$city' WHERE id = $user_id";
    $_SESSION['city'] = $city;
  }
  if ($district != $_SESSION['district']) {
    $query[] = "UPDATE `users` SET `district` = 'district' WHERE id = $user_id";
    $_SESSION['district'] = $district;
  }
  foreach($query as $queries)
  {
    if (!empty($queries))
    {
      if (mysqli_query($conn,$queries))
      {
        $message[] = 'Update data successfully';

      }
      else
      {
        echo "error: " . mysqli_error($conn) . "<br>";
      }
    }
  }

}
if (isset($_POST["finish"]))
{
  header("location:home.php");
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
</head>
<body>

<?php include 'header.php'; ?>
<div class="heading">
   <h3>EDIT INFORMATION</h3>
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
    <h2>EDIT INFORMATION</h2>
    <form action="" method="POST" id="form">
  <?php
    $user_id = $_SESSION['user_id'];
    $sql = mysqli_query($conn, "SELECT * FROM `users` WHERE id=$user_id");
    $check = mysqli_fetch_assoc($sql); // lấy từng cột giá trị trên bảng users
  ?>
  <table>
    <tr>
      <td><label for="name">Name:</label></td>
      <td><input type="text" id="name" name="name_change" value="<?php echo $check['name']; ?>" class="box"></td>
    </tr>
    <tr>
      <td><label for="email">Email:</label></td>
      <td><input type="email" id="email" name="email_change" value="<?php echo $check['email']; ?>" class="box"></td>
    </tr>
    <tr>
      <td><label for="phone">Teleohone Number:</label></td>
      <td><input type="tel" id="phone" name="phone_number" value="<?php echo $check['phone_number']; ?>" class="box"></td>
    </tr>
    <tr>
      <td><label for="address">House Number:</label></td>
      <td><input type="text" id="address" name="address" value="<?php echo $check['house_number']; ?>" class="box"></td>
    </tr>
    <tr>
      <td><label for="road">Road</label></td>
      <td><input type="text" id="road" name="road" value="<?php echo $check['road']; ?>" class="box"></td>
    </tr>
    <tr>
      <td><label for="ward">Ward:</label></td> 
      <td><input type="text" id="ward" name="ward" value="<?php echo $check['ward']; ?>" class="box"></td>
    </tr>
    <tr>
      <td><label for="district">District:</label></td> 
      <td><input type="text" id="district" name="district" value="<?php echo $check['district']; ?>" class="box"></td>
    </tr>
    <tr>
      <td><label for="city">City:</label></td>
      <td><input type="text" id="city" name="provinces" value="<?php echo $check['city']; ?>" class="box"></td>
    </tr>
    

  </table>
  <div class="button_form">
    <input type="button" name="reload" onclick="reloadPage()" value="Return">
    <input type="submit" name="submit" value="Submit">
    <input type="submit" name="finish" value="Finish">
  </div>
</form>
  </div>
</div>

  <script>
    function reloadPage()
    {
      document.getElementById("form").requestFullscreen();
    }
  </script>
</body>
