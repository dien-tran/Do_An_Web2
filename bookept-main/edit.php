<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login_customer.php');
    exit();
}

if (isset($_POST['name_change']) || isset($_POST['email_change']) || isset($_POST['phone_number']) || isset($_POST['address']) || isset($_POST['city']) || isset($_POST['ward']) || isset($_POST['road']) || isset($_POST['district'])) {
  {
    if (isset($_POST['submit']))
    {
  $name = mysqli_real_escape_string($conn, $_POST['name_change']);
  $email = mysqli_real_escape_string($conn, $_POST['email_change']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone_number']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $city = $_POST['city'];                                                                                                                       
  $ward = $_POST['ward'];
  $road = mysqli_real_escape_string($conn, $_POST['road']);
  $district = $_POST['district'];
   
    $success = false; // Biến cờ để kiểm tra xem có truy vấn SQL thành công không
  
     // Mảng để lưu các truy vấn SQL
    $errors = array(); // Mảng để lưu các lỗi
  
    if (empty($_POST['phone_number'])) {
        array_push($errors, 'Số điện thoại không được để trống');
    }
  
    if ($name != $_SESSION['name']) {
        $queries[] = "UPDATE `users` SET `name` = '$name' WHERE id = $user_id";
        $_SESSION['name'] = $name;
    }
  
    if ($email != $_SESSION['email']) {
        $queries[] = "UPDATE `users` SET `email` = '$email' WHERE id = $user_id";
        $_SESSION['email'] = $email;
    }
  
    if ($phone != $_SESSION['phone_number']) {
        if (preg_match('/^[0-9]+$/', $phone)) {
            // Kiểm tra độ dài của số điện thoại
            if (strlen($phone) == 10) {
                $queries[] = "UPDATE `users` SET `phone_number` = '$phone' WHERE id = $user_id";
                $_SESSION['phone_number'] = $phone;
            } else {
                array_push($errors, 'Số điện thoại phải có 10 chữ số');
            }
        } else {
            array_push($errors, 'Số điện thoại không hợp lệ. Vui lòng kiểm tra lại!');
        }
    }
  
    if ($address != $_SESSION['house_number']) {
        $queries[] = "UPDATE `users` SET `house_number` = '$address' WHERE id = $user_id";
        $_SESSION['house_number'] = $address;
    }
  
    if ($road != $_SESSION['road']) {
        $queries[] = "UPDATE `users` SET `road` = '$road' WHERE id = $user_id";
        $_SESSION['road'] = $road;
    }
  
    if ($ward != $_SESSION['ward']) {
        $queries[] = "UPDATE `users` SET `ward` = '$ward' WHERE id = $user_id";
        $_SESSION['ward'] = $ward;
    }
  
    if ($district != $_SESSION['district']) {
        $queries[] = "UPDATE `users` SET `district` = '$district' WHERE id = $user_id";
        $_SESSION['district'] = $district;
    }
  
    if ($city != $_SESSION['city']) {
        $queries[] = "UPDATE `users` SET `city` = '$city' WHERE id = $user_id";
        $_SESSION['city'] = $city;
    }
  
    foreach ($queries as $query) {
        if (!empty($query)) {
            if (mysqli_query($conn, $query)) {
                $success = true;
            } else {
                array_push($errors, 'Lỗi: ' . mysqli_error($conn));
            }
        }
    }
  
    if ($success) {
        $message[] = 'Cập nhật dữ liệu thành công.';
    }
  
    if (!empty($errors)) {
        echo "Có lỗi xảy ra:";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
  }
}
  
  if (isset($_POST["finish"])) {
    header("location:home.php");
    exit();
  }
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
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="edit_customer.css">
   <link rel="stylesheet" href="styles/main.css">
   <style>
  .form-select {
    
    font-size: 16px;
    display: inline-block;
    width: 33.33%;
    margin-right: 20px;
    width: 100%; /* Đặt chiều rộng là 100% để các select box dài hết chiều rộng của cột */
        max-width: 400px; /* Tùy chỉnh chiều rộng tối đa của các select box */
  }
</style>
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
    <form action="edit.php" method="POST" id="form">
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
      <td><label for="road">Road:</label></td>
      <td><input type="text" id="road" name="road" value="<?php echo $check['road']; ?>" class="box"></td>
    </tr>
    
    
 <tr>
        <td><label for="ward">Ward:</label></td>
        <td>
            <select class="form-select form-select-sm" name="ward" id="ward" aria-label=".form-select-sm">
                <option value="">Chọn phường xã</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $selected = ($_POST['ward'] == "Phường $i") ? 'selected' : '';
                    echo "<option value='Phường $i' $selected>Phường $i</option>";
                    $selected = ($check['ward'] == "Phường $i") ? 'selected' : '';
                    echo "<option value='Phường $i' $selected>Phường $i</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label for="district">District:</label></td>
        <td>
            <select class="form-select form-select-sm mb-3" name="district" id="district" aria-label=".form-select-sm">
                <option value="">Chọn quận huyện</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                  $selected = ($_POST['district'] == "Quận $i") ? 'selected' : '';
                  echo "<option value='Quận $i' $selected>Quận $i</option>";
                  $selected = ($check['district'] == "Quận $i") ? 'selected' : '';
                  echo "<option value='Quận $i' $selected>Quận $i</option>";
              }
                
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label for="city">City:</label></td>
        <td>
            <select class="form-select form-select-sm mb-3" name="city" id="city" aria-label=".form-select-sm">
                <option value="" selected>Chọn tỉnh thành</option>
                <option value="Hồ Chí Minh" selected>Thành Phố Hồ Chí Minh</option>
            </select>
        </td>
    </tr>
    </table>
  <div class="button_form">
  <input type="submit" name="reload" id="return" value="Finish" form="form">
  <input type="submit" name="submit" id ="submitBtn" value="Submit">
  <input type="button" name="finish" value="Return" onclick="window.location.href='home.php';">

  </div>

  </form>

</body>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form').addEventListener('submit', function(event) {
      var phone = document.getElementById('phone').value.trim();
      var name = document.getElementById('name').value.trim();
      var email = document.getElementById('email').value.trim();
      var address = document.getElementById('address').value.trim();
      var city = document.getElementById('city').value.trim();
      var road = document.getElementById('road').value.trim();
      var district = document.getElementById('district').value.trim();
      var ward = document.getElementById('ward').value.trim();
      
      // Check if any field is empty
      if (name === "" || phone === "" || email === "" || address === "" || city === "" || road === "" || district === "" || ward === "") {
        event.preventDefault(); // Prevent form submission
        alert("You should fill out the form completely."); // Show error message

        // Focus on the first empty field
        if (name === "") {
          document.getElementById('name').focus();
        } else if (phone === "") {
          document.getElementById('phone').focus();
        } else if (email === "") {
          document.getElementById('email').focus();
        } else if (address === "") {
          document.getElementById('address').focus();
        } else if (city === "") {
          document.getElementById("city").focus();
        } else if (road === "") {
          document.getElementById("road").focus();
        } else if (district === "") {
          document.getElementById("district").focus();
        } else if (ward === "") {
          document.getElementById("ward").focus();
        }
      }
    });
  });
  
  function ReturnForm(event) {
    event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu mặc định

    // Hiển thị hộp thoại xác nhận
    var confirmed = confirm("Do you want to return to the old data?");

    // Reset form nếu người dùng xác nhận
    if (confirmed) {
        document.getElementById("form").reset();
    }
}

// Gắn sự kiện cho nút Return
document.getElementById('return').addEventListener('click', ReturnForm);

</script>
