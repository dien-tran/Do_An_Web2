<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $password2 = mysqli_real_escape_string($conn, md5($_POST['password2']));
   $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
   $invalidFields = array();
   // Kiểm tra xem người dùng đã tồn tại hay chưa
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE name='$name' or email = '$email' ") or die('query failed');
   if (mysqli_num_rows($select_users) > 0) {
      $message[] = 'User already exists!';
   
   }// Khai báo mảng chứa các trường không hợp lệ
   else {
      

      
         if ($pass != $password2) {
      // Nếu mật khẩu không trùng khớp, xóa cả hai mật khẩu và focus tới mật khẩu
      $invalidFields[] = 'password';
      $invalidFields[] = 'password2';
  }
  
  // Nếu cả số điện thoại và mật khẩu không hợp lệ
  if (!preg_match('/^\d{10}$/', $phone_number) && $pass != $password2) {
      // Xóa số điện thoại và mật khẩu, focus tới mật khẩu
      $invalidFields[] = 'phone_number';
      $invalidFields[] = 'password';
      $invalidFields[] = 'password2';
  }
// Kiểm tra số điện thoại và mật khẩu
if (!preg_match('/^\d{10}$/', $phone_number)) {
    // Nếu số điện thoại không hợp lệ, xóa và focus tới số điện thoại
    $invalidFields[] = 'phone_number';
}



// Kiểm tra xem có trường nào không hợp lệ không
if (!empty($invalidFields)) {
    // Có lỗi, hiển thị thông báo lỗi và không thực hiện lưu dữ liệu
    $message[] = 'Please check the entered data.';
}

      else {
         $user_type = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin' ? 'admin' : 'user';
         $insert_query = "INSERT INTO `users` (name, email, password, user_type, phone_number,status) VALUES ('$name', '$email', '$pass', 'user', '$phone_number','1')";
         if (mysqli_query($conn, $insert_query)) {
            header('location: admin_users.php');
            exit();
         } else {
            $message[] = 'Registration failed!';
         }
      }
   }
   
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bookept | Register</title>
   <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
   <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
   <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/customers/register.css">

</head>

<body>
<div class="message-container">
        <?php
        if(isset($message)) {
            foreach($message as $msg) {
                echo '<div class="message">
                        <span>' . $msg . '</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                      </div>';
            }
        }
        ?>
    </div>
   <div class="form-container ">
      <div class="container">
         <form class="form" action="" method="post">
            <h2>REGISTER</h2>
            <div class="input-form"> <!--name -->
               <div class="icon">
                  <img src="./public/form/user.svg" alt="user">
               </div>
               <div class="fill">
                  <input type="text" name="name" placeholder="enter your name" value="<?php if (isset($name)) echo $name; ?>" required class="box">
               </div>
            </div>

            <div class="input-form"><!-- email -->
               <div class="icon">
                  <img src="./public/form/letter-svgrepo-com.svg" alt="gmail">
               </div>
               <div class="fill">
                  <input type="email" name="email" placeholder="enter your email"value="<?php if (isset($email)) echo $email; ?>"  required class="box">
               </div>
            </div>


            <div class="input-form"> <!--pass1 -->
               <div class="icon">
                  <img src="./public//form/finger_print.svg" alt="finger_print"> <!-- dấu pass-->
               </div>
               <div class="fill">
                  <input type="password" name="password" placeholder="enter your password" required class="box"value="<?php if (isset($_POST['password'])) echo htmlspecialchars($_POST['password']); ?>">
                  <?php if (isset($invalidFields) && in_array('password', $invalidFields)) {
                     echo '<div  style="color: red;" class="error-message">Password must match!</div>';
                  } ?>
               </div>
            </div>

            <div class="input-form"> <!--pass2 -->
               <div class="icon">
                  <img src="./public//form/finger_print.svg" alt="finger_print"> <!-- dấu pass-->
                </div>
            <div class="fill">
                  <input type="password" name="password2" placeholder="confirm your password" required class="box" value="<?php if (isset($_POST['password'])) echo htmlspecialchars($_POST['password']); ?>">
                  <?php if (isset($invalidFields) && in_array('password2', $invalidFields)) {
                     echo '<div  style="color: red;" class="error-message">Password confirmation must match!</div>';
                  } ?>
               </div>
            </div>

            <div class="input-form <?php if (isset($invalidFields) && in_array('phone_number', $invalidFields)) echo 'invalid'; ?>"> <!--number -->
               <div class="icon">
                  <img src="./public//form/phone-office-svgrepo-com.svg" alt="phone_icon"> <!-- dấu pass-->
               </div>
               <div class="fill">
                  <input type="tel" name="phone_number" placeholder="Number phone" required class="box" value="<?php if (isset($_POST['phone_number'])) echo htmlspecialchars($_POST['phone_number']); ?>">
                     <?php if (isset($invalidFields) && in_array('phone_number', $invalidFields)) {
                        echo '<div  style="color: red;" class="error-message">Invalid phone number. Please check!</div>';
                     } ?>
               </div>
   </div>



            <div class="btn-group">
               <button class="btn" type="submit" name="submit" value="Register">Register</button>
            </div>
            <br>
            <div class="register">
               <p>Already have an account? <a href="login_customer.php" style="color: violet">Login now</a></p>
            </div>

         </form>
      </div>
   </div>
   <script>
        document.addEventListener("DOMContentLoaded", function() {
            const invalidFields = document.querySelectorAll('.invalid input');
            if (invalidFields.length > 0) {
                invalidFields[0].focus(); // Focus vào trường input đầu tiên không hợp lệ
            }
        });
    </script>
</body>

</html>