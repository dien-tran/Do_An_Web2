<!DOCTYPE html>
<html lang="en">

<head>
 
   <link rel="stylesheet" href="./styles/login.css">
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
   <link rel="stylesheet" href="./styles/login.css">
   
</head>

<body>
<div id="alertMessage1" class="alert-message" style="display: none;">
    The account has been locked. Please call the hotline
</div>
<div id="alertMessage2" class="alert-message" style="display: none;">
      Invalid email or password
</div>
   <div class="form-container">
      <form class="login_form"action="" method="post">
         <div class="form-inner">
            <h2>Login now</h2>
            <div class="input-group">
               <div class="icon">
                  <img src="./public/form/user.svg" alt="user">
               </div>
               <input type="email" name="email" placeholder="enter your email" required />
            </div>
            <div class="input-group">
               <div class="icon">
                  <img src="./public//form/finger_print.svg" alt="finger_print">
               </div>
               <input type="password" name="password" placeholder="enter your password" required />
            </div>
            <div class="btn-group">
               <button class="btn btn--primary" type="submit" name="submit" value="login now">Sign in</button>
            </div>
            <br>
            <p>Don't have account? <a class="btn--text" href="customer_register.php" style="color:#c000ff">Register now</a></p>
         </div>
      </form>
   </div>
   <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->





</body>

</html>

<?php
include "config.php"; // chứa các cấu hình, thông tin kết nối cơ sở dữ liệu SQL
session_start();
//bắt đầu hoặc khôi phục một phiên làm việc cho người dùng.
//lưu trữ thông tin về người dùng trong suốt thời gian họ tương tác với trang web VD :giỏ hàng,...
//=>Sau khi phiên làm việc được bắt đầu
//<=> bạn có thể sử dụng biến $_SESSION để lưu trữ và truy xuất thông tin của người dùng trong suốt phiên làm việc.
if (isset($_POST['submit'])) // kiểm tra giá trị tồn tại và có ko null
{
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   // $conn :là biến được định nghĩa bên config.php . mục đích kết nối csdl MySQL, thực hiện quá trình lọc
   //mysqli_real_escape_string : lọc các kí tự đặc biệt ra để tránh bị hack
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');    // kiểm tra tài khoản đã tồn lại hay chưa 
   if (mysqli_num_rows($select_users) > 0) // kiểm tra dòng SQL của user đó có lớn hơn 0 ? nếu lớn hơn ko là tồn tại
   //bảng "user" cả email và password đều trùng khớp với thông tin mà người dùng đã nhập.
   {

   
      $check = mysqli_fetch_assoc($select_users); // lấy dòng có giá trị trùng với giá trị user
      // if ($check['user_type'] == 'admin') 
      // {
      //    $_SESSION['admin_id'] = $check['id'];
      //    $_SESSION['admin_name'] = $check['name']; 
      //    $_SESSION['admin_email'] = $check['email'];
      //    $_SESSION['admin_passwword'] = $check['passwword'];
      //    //$_session: dùng để lưu thông tin lại trên server, vì v ngay khi người dùng(admin or user) out ra vào lại thì tk vẫn còn
      //    header('location:admin.php'); //Chuyển hướng người dùng đến trang admin_page.php.
      // }
      if ($check['user_type'] == 'user' ) 
      {
         if ($check['status']=='1')
         {
            $_SESSION['user_id'] = $check['id'];
            $_SESSION['user_name'] = $check['name'];
            $_SESSION['user_email'] = $check['email'];
            $_SESSION['user_passwword'] = $check['passwword'];
            header('location:home.php');
         }
         else
         {
            echo '<script>alert("The account has been locked. Please call the hotline");</script>';
         }
                 
      }
      
   }
   else
   {
      echo '<script>alert("Invalid email or password");</script>';
   }

} ?>