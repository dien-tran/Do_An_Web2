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
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $city = $_POST['city'];
  $ward =$_POST['ward'];
  $road = $_POST['road'];
  $district=$_POST['district'];
  // ban đầu. không có mảng arry thì session là:joppy đổi thành xucana thành công. nhưng sao đó đổi thành modmod  và bấm nút "Submit", thì lại không thành công . 
  // nguyên nhân:thay đổi thông tin từ "xucana" thành "modmod", điều kiện "xucana" sẽ được kiểm tra ở phía trên và một truy vấn cập nhật tên mới sẽ được tạo ra và thực thi. Sau đó, khi đến điều kiện "modmod", nếu không thay đổi bất kỳ trường thông tin nào khác, không có truy vấn SQL mới nào được tạo ra, vì vậy tên "modmod" không được cập nhật vào cơ sở dữ liệu.
  // dùng mảng arry () : sẽ được cập nhật bằng cách thêm giá trị mới vào mảng cho mỗi trường có dữ liệu mới được nhập vào form
  // giả sử đổi thành xucana thì arry sẽ thêm 1 trường đổi tên thành xucana sau đó foreach nó sẽ duyệt qua mảng và đổi tên. khi đổi thành modmod tiếp và submit. thì thêm trường đổi tên vào arry và tiếp tục foreach. việc này sẽ giúp không ghi đè dữ liệu
  $query=array();
  if ($name != $_SESSION['name']) {
    $query[] = "UPDATE `users` SET `name` = '$name' WHERE id = $user_id";
    $_SESSION['name'] = $name;
  } 

  else if ($email != $_SESSION['email'] ) {
    $query[] = "UPDATE `users` SET `email` = '$email' WHERE id = $user_id";
    $_SESSION['email'] = $email;
  }
  else if ($phone != $_SESSION['phone_number']) {
    $query[] = "UPDATE `users` SET `phone_number` = '$phone' WHERE id = $user_id";
    $_SESSION['phone_number'] = $phone;
  } 
 else if (isset($_POST['address']) &&$address != $_SESSION['house_number'] ) 
  {
    $query[] = "UPDATE `users` SET `house_number` = '$address' WHERE id = $user_id";
    $_SESSION['house_number'] = $address;
  }

  elseif ($road != $_SESSION['road']&& $road!="") {
  $query[] = "UPDATE `users` SET `road` = '$road' WHERE id = $user_id";
  $_SESSION['road'] = $road;
}

  else if ($ward != $_SESSION['ward'] &&$ward!="") {
    $query[] = "UPDATE `users` SET `ward` = '$ward' WHERE id = $user_id";
    $_SESSION['ward'] = $ward;
}

 else if ($city != $_SESSION['city'] && $city!="") {
    $query[] = "UPDATE `users` SET `city` = '$city' WHERE id = $user_id";
    $_SESSION['city'] = $city;
}


else
{
  
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
    <input type="submit" name="reload" value="Return" form="myForm" onclick="return ReturnForm()">
    <input type="submit" name="submit" id ="submitBtn" value="Submit">
    <input type="submit" name="finish" value="Finish">
  </div>

  </form>

</body>

  <script>
  function ReturnForm() {
    event.preventDefault();
    var formData = new FormData(document.getElementById("form"));
    var result = {};
    for (var pair of formData.entries()) {
        result[pair[0]] = pair[1];
    }
    // var check= confirm("Are you delected the data ?");
    // if (check)
    // {
    //   document.getElementById("form").reset();
    //   return false;
    // }
    // else
    // {
    //   return false;
    // }
    document.getElementById("form").reset();
}


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
        // Kiểm tra nếu bất kỳ trường nào rỗng
        if (name === "" || phone === "" || email === "" || address==="" || city===""|| road===""|| district===""||ward==="") {
            event.preventDefault(); // Ngăn chặn việc gửi form
            alert("You should fill out the form completely."); // Hiển thị thông báo lỗi

            // Tập trung (focus) lại vào ô dữ liệu đầu tiên rỗng
            if (name === "") {
                document.getElementById('name').focus();
            } if (phone === "") {
                document.getElementById('phone').focus();
            }  if (email === "") {
                document.getElementById('email').focus();
            }
            if (address==="")
            {
              document.getElementById('address').focus();
            } 
            if (city==="")
            {
              document.getElementById("city").focus();
            
            }
            if (road==="")
            {
              document.getElementById("road").focus();
              
            }
            if (district==="")
            { 
              document.getElementById(district).focus()

            }
            if (ward==="")
            {
              document.getElementById(ward).focus();
            }
        }
    });
});


</script>
  