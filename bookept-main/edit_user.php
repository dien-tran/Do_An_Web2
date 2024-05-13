<?php
include 'config.php';
if(isset($_GET['id']))
{
    $user_id = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
    if (isset($_POST['submit'])) 
    {
        if(mysqli_num_rows($sql)>0)
    {
        $check= mysqli_fetch_assoc($sql);
        $phone = $name = $email = $address = $city = $road = $district = $ward = "";

    // Check if phone number is set and not empty in $_POST

    // Check if other form fields are set and not empty in $_POST
    $success = false; // Biến cờ để kiểm tra xem có truy vấn SQL thành công không

    $queries = array(); // Mảng để lưu các truy vấn SQL
    if (isset( $_POST['name_change'])) {
      $name = mysqli_real_escape_string($conn, $_POST['name_change']);
      $check_name= mysqli_query($conn, "SELECT * FROM users WHERE name = '$name' AND id != $user_id");
      if(mysqli_num_rows($check_name)>0)
      {
        $message[] = 'This name already exists, please update it.';
        $check1=false;
      }
      else
      {
        $queries[] .= "UPDATE `users` SET `name` = '$name' WHERE id = $user_id";
        $_SESSION['name'] = $name;
        $check1=true;
      }
    }
    if (isset($_POST['email_change'])) {
      $email = mysqli_real_escape_string($conn, $_POST['email_change']);
      $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND id != $user_id");
      if (mysqli_num_rows($check) > 0) {
          $message[] = 'This email already exists, please update it.';
          $check2=false;
      } else {
          $queries[] = "UPDATE `users` SET `email` = '$email' WHERE id = $user_id";
          $_SESSION['email'] = $email;
          $check2=true;
      }
  }
  
  
    if (isset($_POST['phone_number'])) {
      $phone = mysqli_real_escape_string($conn, $_POST['phone_number']);
      // Rest of your code for handling phone number goes here
      if (!empty($phone)) {
          if (preg_match('/^[0-9]+$/', $phone)) {
              // Kiểm tra độ dài của số điện thoại
              if (strlen($phone) == 10) {
                  $queries[] .= "UPDATE `users` SET `phone_number` = '$phone' WHERE id = $user_id";
                  $check3=true;
              } else {
                  $message[] = 'The phone number must be 10 digits.';
                  $check3=false;
              }
          } else {
              $message[] = 'The phone number is invalid. Please check!';
          }
        }
      }
          if (isset($_POST['address'])) {
            $address = mysqli_real_escape_string($conn, $_POST['address']);
                $queries[] .= "UPDATE `users` SET `house_number` = '$address' WHERE id = $user_id";
                $_SESSION['house_number'] = $address;
                $check4=true;
            
        }
    
        // Check if road is set in $_POST
        if (isset($_POST['road'])) {
            $road = mysqli_real_escape_string($conn, $_POST['road']);
          
                $queries[] .= "UPDATE `users` SET `road` = '$road' WHERE id = $user_id";
                $_SESSION['road'] = $road;
                $check5=true;
            
            
        }
    
        // Check if ward is set and not empty in $_POST
        if (isset($_POST['ward'])) {
          $ward = $_POST['ward'];
              $queries[] .= "UPDATE `users` SET `ward` = '$ward' WHERE id = $user_id";
              $_SESSION['ward'] = $ward;
              $check6=true;
            
      }
  
      // Check if district is set and not empty in $_POST
      if (isset($_POST['district'])) {
          $district = $_POST['district'];
              $queries[] .= "UPDATE `users` SET `district` = '$district' WHERE id = $user_id";
              $_SESSION['district'] = $district;
              $check7=true;
            
      }
  
      // Check if city is set and not empty in $_POST
      if (isset($_POST['city'])) {
          $city = $_POST['city'];
              $queries[] .= "UPDATE `users` SET `city` = '$city' WHERE id = $user_id";
              $_SESSION['city'] = $city;
              $check8=true;
      }
      $updateSuccess=false;
      // $ck=true;
      foreach($queries as $query)
      {
        if (!empty($query))
        {
          if (mysqli_query($conn,$query))
          {
            $updateSuccess = $updateSuccess && true;
      
          }
          else
          {
            // $ch=false;
            $updateSuccess=false;
            echo "error: " . mysqli_error($conn) . "<br>";
            break; // Thoát khỏi vòng lặp nếu có bất kỳ truy vấn nào thất bại
          }
        }
      }
      if ($check1==true && $check2==true && $check3==true && $check4==true && $check5==true && $check6==true && $check7==true && $check8==true) {
        // Nếu đã thành công, hiển thị thông báo
        $message[] = 'Update data successfully';
      }
      
      }
}
}

if (isset($_POST["finish"])) {
    header("location:admin_users.php");
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
<?php
if (isset($message) && is_array($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>' . $msg . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>';
   }
}
?>
<!-- <div class="heading">
   <h3>EDIT INFORMATION</h3>
</div> -->
<div class="from_container">

  <div class="container">
    <h2>EDIT USERS INFORMATION</h2>
    <form action="" method="POST" id="form">
  <?php
    $user_id = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
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
      <td><label for="phone">Phone Number:</label></td>
      <td><input type="tel" id="phone" name="phone_number" value="<?php echo isset($phone) ? $phone : $check['phone_number']; ?>" class="box"></td>   
     </tr>
    
    <script>
    <?php if (isset($_POST['phone_number']) && (strlen($phone) != 10 || !preg_match('/^[0-9]+$/', $phone))) : ?>
    document.getElementById('phone').focus();
    <?php endif; ?>
</script>
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
                <option value="" selected  disabled>Choose ward</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $selected = ($_POST['ward'] == "Ward $i") ? 'selected' : '';
                    "<option value='Ward $i' $selected>Ward $i</option>";
                    $selected = ($check['ward'] == "Ward $i") ? 'selected' : '';
                    echo "<option value='Ward $i' $selected>Ward $i</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label for="district">District:</label></td>
        <td>
            <select class="form-select form-select-sm mb-3" name="district" id="district" aria-label=".form-select-sm">
                <option value="" selected disabled >Choose district</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                  $selected = ($_POST['district'] == "District $i") ? 'selected' : '';
                  "<option value='District $i' $selected>District $i</option>";
                  $selected = ($check['district'] == "District $i") ? 'selected' : '';
                  echo "<option value='District $i' $selected>District $i</option>";
              }
                
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><label for="city">City:</label></td>
        <td>
            <select class="form-select form-select-sm mb-3" name="city" id="city" aria-label=".form-select-sm">
                <option value="" selected  disabled>Choose city</option>
                <option value="Hồ Chí Minh" selected>Ho Chi Minh city</option>
            </select>
        </td>
    </tr>
    </table>
  <div class="button_form" style="font-size:15px;">
  <input type="submit" name="submit" id ="submitBtn" value="Submit">
  <input type="submit" name="reload" id="return" value="Reset" form="form">
  <input type="button" name="finish" value="Return" onclick="window.location.href='admin_users.php';">

  </div>

  </form>

</body>

<script src="js/script.js"></script>
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

    // Lấy giá trị mới từ form và loại bỏ ký tự khoảng trắng
    var formData = new FormData(document.getElementById("form"));
    var result = {};
    for (var pair of formData.entries()) {
        result[pair[0]] = pair[1].trim(); // Loại bỏ ký tự khoảng trắng
    }

    // Chuyển đổi dữ liệu sang JSON
    var newData = JSON.stringify(result);
    var originalData = <?php echo json_encode($check); ?>;

    // Khai báo biến Check ở đây
    var Check = true;

    // So sánh dữ liệu mới với dữ liệu ban đầu từ PHP
    if (newData !== JSON.stringify(originalData)) {
        // Nếu có thay đổi, set Check thành false
        Check = false;
    }

    // Hiển thị hộp thoại xác nhận nếu có thay đổi
    if (!Check) {
      var confirmed = confirm("Do you want to return to the old data?");
        if (confirmed) {
            document.getElementById("form").reset();
        }
    } else {
        // Nếu không có thay đổi, reset form
        document.getElementById("form").reset();
    }
}

// Gắn sự kiện cho nút Return
document.getElementById('return').addEventListener('click', ReturnForm);




</script>
